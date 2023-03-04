<template>
    <div class="task">
        <a :href="route('dashboard-task-detail', taskId)">
            <div class="task-heading">{{ title }}</div>
            <div class="task-priority task-low-priority" v-if="priority == 1" >Priorita: Nízka</div>
            <div class="task-priority task-medium-priority" v-else-if="priority == 2" >Priorita: Stredná</div>
            <div class="task-priority task-high-priority" v-else-if="priority == 3" >Priorita: Vysoká</div>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            taskId: Number,
            title: String,
            priority: Number,
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

    .task-heading{
        font-weight: bold;
    }

    .task-priority{
        margin-top: 5px;
    }
    .task-low-priority{
        color: green;
    }
    .task-medium-priority{
        color: rgb(187, 187, 12);
    }

    .task-high-priority{
        color: red;
    }

    a {
        display: block;
        text-decoration: none;
    }

    a:hover{
        text-decoration: none;
        color: var(--stuba-sgt-green-color);
    }
</style>