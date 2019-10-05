<template>
<form @submit.prevent="savePlan">
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control" v-model="planData.name" name="name" placeholder="Billy's Workout" required  autofocus>

        </div>
    </div>
    <div class="form-group row">
        <label for="notes" class="col-md-4 col-form-label text-md-right">Description</label>

        <div class="col-md-6">
            <input id="notes" type="text" class="form-control"  v-model="planData.description"  name="notes">

        </div>
    </div>
    <div class="form-group row">
        <label for="exercise" class="col-md-4 col-form-label text-md-right">Author</label>

        <div class="col-md-6">
            <input id="exercise" type="text" class="form-control" name="exercise" v-model="exercise" required>

        </div>
    </div>

    <div class="form-group row">
        <label for="repetition" class="col-md-4 col-form-label text-md-right">Goal(s):</label>

        <div class="col-md-6">
            <input id="repetition" type="text" class="form-control" name="repetition">

        </div>
    </div>
    <div class="form-group row">
        <div class=" offset-md-4 col-md-6">
            <button type="submit" class="btn btn-primary ">
                Save
            </button>
        </div>
    </div>
    
    <hr>
    <div class="form-group row">
        <label for="workout" class="col-md-4 col-form-label text-md-right">Workout: </label>

        <div class="col-md-6">
            <input id="workout" type="text" class="form-control" v-model="workout" name="workout">

        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 offset-md-4">
            <input type="button" name="addworkout" value="Add Workout" v-on:click="addWorkout" class="btn btn-primary">
        </div>
    </div>
    
    <ul class="list-group">
        <li class="list-group-item" v-for="workout in workoutList">{{ workout.name }}</li>
    </ul>
</form>
</template>

<script>
    export default {
        props: ['planData'],
        mounted() {
            console.log(this.planData);
            this.plan_name = this.planData.name;
            console.log('mounted:'+this.plan_name);
            this.fetchWorkoutList();
        },
        data() {
            console.log('data:'+this.plan_name);
            return {
                workoutList: [],
                exercises: [],
                exercise: "",
                workout: "",
                plan_name: this.planData.name
            };
        },
        methods: {
            fetchWorkoutList() {
                axios.get('/api/workouts/1').then((res) => {
                    this.workoutList = res.data;
                });
            },
            savePlan() {
                axios.post('/plan', {body: this.body}).then(res => {
                    console.log(res.data);
                }).catch(e => {
                    console.log(e);
                });
                
            },
            addExercise() {
                this.exercises.push(this.exercise);
                this.exercise = "";

                // axios.post('/tweet/save', {body: this.body}).then(res => {
                //     console.log(res.data);
                // }).catch(e => {
                //     console.log(e);
                // });
                
            },
            addWorkout() {
                axios.post('/workouts', {name: this.workout, plan_id: this.planData.id}).then(res => {
                    this.fetchWorkoutList();
                    this.workout = "";
                    console.log(res.data);
                }).catch(e => {
                    console.log(e);
                });
                
            }
        }
    }
</script>
