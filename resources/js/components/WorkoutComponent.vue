<template>
<form @submit.prevent="addExercise">
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control" name="name" v-model="workoutData.name" placeholder="Billy's Workout" required  autofocus>
        </div>
    </div>
    <div class="form-group row">
        <label for="focus" class="col-md-4 col-form-label text-md-right">Focus</label>

        <div class="col-md-6">
            <input id="focus" type="text" class="form-control" name="focus" placeholder="Upper body, lower body, endurance...">
        </div>
    </div>

    <div class="form-group row">
        <label for="notes" class="col-md-4 col-form-label text-md-right">Notes</label>

        <div class="col-md-6">
            <input id="notes" type="text" class="form-control" name="notes">

        </div>
    </div>
    <hr>
    <div class="form-group row">
        <label for="exercise" class="col-md-4 col-form-label text-md-right">Exercise</label>

        <div class="col-md-6">
            <input id="exercise" type="text" class="form-control" v-model="query" v-on:keyup="autoComplete" name="exercise" required>
            <div class="panel-footer" v-if="results.length">
               <ul class="list-group">
                <li class="list-group-item" v-for="(result, index) in results" @click="suggestionClick(index)">
                 <a href="#">{{ result.name }}</a>
                </li>
               </ul>
              </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="repetition" class="col-md-4 col-form-label text-md-right">Repetition</label>

        <div class="col-md-6">
            <input id="repetition" type="text" class="form-control" name="repetition">

        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">Rounds</label>

        <div class="col-md-6">
            <input id="rounds" type="text" class="form-control" name="rounds">

        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Add
            </button>
        </div>
    </div>
    <hr>
    <ul class="list-group">
        <li class="list-group-item" v-for="exercise in exerciseList">{{ exercise.name }}</li>
    </ul>
</form>
</template>

<script>
    export default {
        props: ['workoutData'],
        mounted() {
            console.log('Component mounted.');
            this.fetchExerciseList();
        },
        data() {
            return {
                exerciseList: [],
                exercise: "",
                query: '',
                results: [],
                open: false
            };
        },
        computed: {
            openSuggestion() {
                return this.selection !== "" &&
                       this.matches.length != 0 &&
                       this.open === true;
            }
        },
        methods: {
            fetchExerciseList() {
                axios.get('/api/exercises/1').then((res) => {
                    this.exerciseList = res.data;
                });
            },
            addExercise() {
                this.exerciseList.push(this.selection);
                this.result = "";

                // axios.post('/tweet/save', {body: this.body}).then(res => {
                //     console.log(res.data);
                // }).catch(e => {
                //     console.log(e);
                // });
                
            },
            saveWorkout() {
                axios.post('/workout', {body: this.body}).then(res => {
                    console.log(res.data);
                }).catch(e => {
                    console.log(e);
                });
                
            },
            autoComplete(){
                this.results = [];
                if(this.query.length > 2){
                 axios.get('/api/searchexercise',{params: {query: this.query}}).then(response => {
                  this.results = response.data;
                 });
                }
            },
            suggestionClick(index) {
                this.selection = this.results[index];
                this.query = this.selection.name;
                this.open = false;
                this.results = [];
                console.log(this.selection);
            },
        }
    }
</script>
