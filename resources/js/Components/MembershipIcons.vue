<template>
    <svg v-if="this.type === 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="25"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path fill="#00FF00" d="M470.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L192 338.7 425.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
        <rect>
            <title>Platné členstvo</title>
        </rect>
    </svg>
    <svg v-else-if="this.type === 0" viewBox="0 0 320 512" width="18"><!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path fill="#FF0000" d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/>
        <rect>
            <title>Neplatné členstvo</title>
        </rect>
    </svg>
</template>

<script>
    export default {
        name: 'MembershipIcons',
        props: ['type']
    }
</script>

<style scoped>
    rect {
    width: 100%;
    height: 100%;
    fill: transparent;
    stroke-width: 5px;
    opacity: 0.5
    }
</style>