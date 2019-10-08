<template>
<form @submit.prevent="saveWorkout">
    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control" name="name" v-model="workoutName" placeholder="Billy's Workout" required  autofocus>
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
    <div class="form-group row">
        <label for="notes" class="col-md-4 col-form-label text-md-right"></label>

        <div class="col-md-6">
            <button type="submit" class="btn btn-primary btn-sm">
                Save
            </button>
        </div>
    </div>
    
    <hr>
    <div v-if="showExerciseAdd">
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
                <input type="button" name="addExercise" value="Add Exercise" v-on:click="addExercise" class="btn btn-primary">
                </div>
        </div>
    </div>
    <hr>
    <ul class="list-group" v-if="exerciseList.length>0">
        <li class="list-group-item" v-for="exercise in exerciseList">{{ exercise.name }} <a href="#" @click="removeExercise(exercise.pivot.id)" class="float-right"><i class="fas fa-minus-circle"></i></a></li>
    </ul>
</form>
</template>

<script>
    export default {
        props: ['userData','workoutData'],
        mounted() {
            console.log('Component mounted.');
            console.log(this.workoutData);
            console.log(this.userData);

            if (this.workoutData)
            {
                this.workout = this.workoutData;
                this.fetchExerciseList();
            }
        },
        data() {
            return {
                exerciseList: [],
                exercise: "",
                query: "",
                results: [],
                open: false,
                workoutNameData: "",
                workout: "",
                showExerciseAddData: false
            };
        },
        computed: {
            openSuggestion() {
                return this.selection !== "" &&
                       this.matches.length != 0 &&
                       this.open === true;
            },
            workoutName: {
                get: function() {
                    return this.workoutNameData;
                },
                set: function (name) {
                  this.workoutNameData = name;
                }
            },
            showExerciseAdd: {
                get: function() {
                    return this.showExerciseAddData;
                },
                set: function (val) {
                  this.showExerciseAddData = val;
                }
            }
        },
        methods: {
            fetchExerciseList() {

                axios.get('/api/exercises/'+this.workoutData.id).then((res) => {
                    this.exerciseList = res.data;
                });
            },
            addExercise() {
                this.exerciseList.push(this.selection);
                this.result = "";
                //this.fetchExerciseList();

                // axios.post('/tweet/save', {body: this.body}).then(res => {
                //     console.log(res.data);
                // }).catch(e => {
                //     console.log(e);
                // });
                
            },
            removeExercise(exerciseid) {
                axios.post('/api/plans/workout/'+this.planData.id+'/'+workoutid, {_method: 'delete'}).then(res => {
                    this.fetchExerciseList();
                    console.log(res.data);
                }).catch(e => {
                    console.log(e);
                });
            },
            saveWorkout() {
                axios.post('/api/workout', {name: this.workoutName, user_id: this.userData.id}).then(res => {
                    console.log(res.data);
                    this.workout = res.data;
                    this.showExerciseAdd = true;
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
