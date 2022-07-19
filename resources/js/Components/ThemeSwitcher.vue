<script>
export default {
    data() {
        return {
            themes: {
                'theme-light': '#F5F6F9',
                'theme-dark': '#222'
            },
            selectedTheme: 'theme-light'
        }
    },
    created() {
        this.selectedTheme = localStorage.getItem('theme') || 'theme-light';
    },
    watch: {
        selectedTheme() {
            document.body.className = document.body.className.replace(/theme-\w+/, this.selectedTheme)

            localStorage.setItem('theme', this.selectedTheme);
        }
    }
}
</script>

<template>
    <div class="flex items-center mr-8">
        <button v-for="(color, theme) in themes" class="rounded-full w-4 h-4 border mr-2"
                :class="{ 'border-cyan-400': selectedTheme === theme }"
                :style="{ backgroundColor: color }"
                @click="selectedTheme = theme"></button>
    </div>
</template>
