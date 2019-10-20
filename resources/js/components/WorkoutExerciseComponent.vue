<template>
<form @submit.prevent="addExercise">
    <ul class="list-group">
        <li class="list-group-item" v-for="exercise in exercises">{{ exercise }}</li>
    </ul>
</form>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.');
            this.fetchExerciseList();
        },
        data() {
            return {
                exerciseList: [],
                exercise: "",
            };
        },
        methods: {
            fetchExerciseList() {
                axios.get('/api/exercises/1').then((res) => {
                    this.exerciseList = res.data;
                });
            },
            addExercise() {
                this.exercises.push(this.exercise);
                this.exercise = "";
            },
            saveWorkout() {
                axios.post('/workout', {body: this.body}).then(res => {
                    console.log(res.data);
                }).catch(e => {
                    console.log(e);
                });
                
            }
        }
    }
</script>
