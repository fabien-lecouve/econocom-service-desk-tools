<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Message;
use App\Models\Project;
use App\Models\ProjectCategoryColorSetting;
use App\Models\ProjectLanguageSetting;
use App\Models\ProjectMessageTypeColorSetting;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class QuickMessageController extends Controller
{
    private EloquentCollection $projects;
    private Collection $allowedProjectIds;

    private array $languages = [];
    private array $data = [];

    public function index(Project $project)
    {
        $this->projects = Project::where('id', $project->id)->get();

        $this->allowedProjectIds = $this->projects->pluck('id');

        $this->buildLanguages();
        $this->buildData();


        return view('quick_messages.index', [
            'projects' => $this->projects,
            'languages' => $this->languages,
            'data' => $this->data,
        ]);
    }

    private function buildLanguages(): void
    {
        $languageSettings = ProjectLanguageSetting::with(['language.setting'])
            ->whereIn('project_id', $this->allowedProjectIds)
            ->orderBy('project_id')
            ->orderBy('language_id')
            ->get();

        $this->languages = $languageSettings
            ->map(function (ProjectLanguageSetting $setting) {
                return [
                    'project_id' => $setting->project_id,
                    'language_id' => $setting->language_id,
                    'code' => $setting->language->code,

                    'salutation' => $setting->language->setting->salutation,
                    'closing' => $setting->language->setting->closing,

                    'signature' => $setting->signature,
                    'internal_phone_override' => $setting->internal_phone_override,
                    'external_phone_override' => $setting->external_phone_override,
                ];
            })
            ->groupBy('project_id')
            ->map(fn ($items) => $items->values())
            ->toArray();
    }

    private function buildData(): void
    {
        $categoryColorSettings = ProjectCategoryColorSetting::with([
            'fontColor',
            'backgroundColor',
            'borderTopColor',
        ])
            ->whereIn('project_id', $this->allowedProjectIds)
            ->get()
            ->keyBy('project_id');

        $messageTypeColorSettings = ProjectMessageTypeColorSetting::with([
            'fontColor',
            'backgroundColor',
            'borderTopColor',
        ])
            ->whereIn('project_id', $this->allowedProjectIds)
            ->get()
            ->groupBy('project_id');

        $categories = Category::query()
            ->whereIn('project_id', $this->allowedProjectIds)
            ->orderBy('project_id')
            ->orderBy('position')
            ->get();

        $messages = Message::with(['translations', 'type'])
            ->whereIn('project_id', $this->allowedProjectIds)
            ->orderBy('project_id')
            ->orderBy('position')
            ->get();

        $messagesByProjectCategory = $messages
            ->map(function (Message $message) use ($messageTypeColorSettings) {
                $colorSetting = $messageTypeColorSettings
                    ->get($message->project_id, collect())
                    ->firstWhere('message_type_id', $message->message_type_id);

                return [
                    'project_id' => $message->project_id,
                    'category_id' => $message->category_id,
                    'code' => $message->code,
                    'label' => $message->label,
                    'content' => $message->translations
                        ->keyBy('language_id')
                        ->map(fn ($t) => $t->content)
                        ->toArray(),
                    'type' => $message->type->code,

                    'font_color' => $message?->fontColor?->hex ?? $colorSetting?->fontColor?->hex,
                    'background_color' => $message?->backgroundColor?->hex ?? $colorSetting?->backgroundColor?->hex,
                    'border_top_color' => $message?->borderTopColor?->hex ?? $colorSetting?->borderTopColor?->hex,
                ];
            })
            ->groupBy(fn ($m) => $m['project_id'] . '-' . $m['category_id']);

        $categoriesByProject = $categories->groupBy('project_id');

        foreach ($categoriesByProject as $projectId => $projectCategories) {
            $items = [];

            $colorSetting = $categoryColorSettings->get($projectId);

            foreach ($projectCategories as $category) {
                $categoryKey = $projectId . '-' . $category->id;

                $items[$category->id] = [
                    'category_id' => $category->id,
                    'parent_id' => $category->parent_id,
                    'code' => $category->code,
                    'label' => $category->label,

                    'font_color' => $category?->fontColor?->hex ?? $colorSetting?->fontColor?->hex,
                    'background_color' => $category?->backgroundColor?->hex ?? $colorSetting?->backgroundColor?->hex,
                    'border_top_color' => $category?->borderTopColor?->hex ?? $colorSetting?->borderTopColor?->hex,

                    'children' => [],
                    'messages' => $messagesByProjectCategory
                        ->get($categoryKey, collect())
                        ->values()
                        ->toArray(),
                ];
            }

            $tree = [];

            foreach ($items as $id => &$item) {
                if ($item['parent_id']) {
                    $items[$item['parent_id']]['children'][] = &$item;
                } else {
                    $tree[] = &$item;
                }
            }

            unset($item);

            $this->data[$projectId] = array_values($tree);
        }
    }
}
