@props(['source'])

<template x-if="{{ $source }}.messages.length">
    <template x-for="message in {{ $source }}.messages" :key="'message-' + message.code">
        <button
            type="button"
            @click="copy(message)"
            :style="getMessageStyle(message)"
            class="quick__button message__button"
            x-text="message.label">
        </button>
    </template>
</template>
