<template>
    <div class="task">
        <a :href="route('dashboard-task-detail', taskId)">
            <div class="font-bold">{{ title }}</div>
            <div class="mt-2 task-low-priority" v-if="taskPriority == 1" >Priorita: Nízka</div>
            <div class="mt-2 task-medium-priority" v-else-if="taskPriority == 2" >Priorita: Stredná</div>
            <div class="mt-2 task-high-priority" v-else-if="taskPriority == 3" >Priorita: Vysoká</div>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            taskId: Number,
            title: String,
            taskPriority: Number,
        },
    }
</script>

<style scoped>
    .task {
        background-color: white; 
        padding: 10px;
        margin-bottom: 10px; 
        border-radius: 10px;
    }

    .task-low-priority{
        color: var(--sgt-color);
        font-weight: bold;
    }
    .task-medium-priority{
        color: rgb(206, 206, 19);
        font-weight: bold;
    }

    .task-high-priority{
        color: red;
        font-weight: bold;
    }

    a {
        display: block;
        text-decoration: none;
    }

    a:hover{
        text-decoration: none;
        color: var(--sgt-color);
    }
</style>