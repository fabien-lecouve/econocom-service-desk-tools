@props(['source'])

<template x-if="{{ $source }}.messages.length">
    <template x-for="message in {{ $source }}.messages" :key="'message-' + message.code">
        <button
            type="button"
            @click="copy(message)"
            :class="{ 'accent-orange': message.type === 'work_note' }"
            x-text="message.label">
        </button>
    </template>
</template>