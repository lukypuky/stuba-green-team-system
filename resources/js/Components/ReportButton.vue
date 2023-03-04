<script>
export default {
    props: ['text']
}
</script>

<template>
    <div class="report-left-section-button-container">
        <button class="buttons report-left-section-button">{{ text }}</button>
    </div>
</template>

<style>
.report-left-section-button-container {
    padding: 5px;
}

.report-left-section-button {
    width: 215px;
}
</style>