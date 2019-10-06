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
            <input id="workout" type="text" class="form-control" v-model="query" v-on:keyup="autoComplete" name="workout">
            <div class="panel-footer" v-if="results.length">
               <ul class="list-group">
                <li class="list-group-item" v-for="(result, index) in results" @click="suggestionClick(index)">
                 <a href="#">{{ result.name }}</a>
                </li>
               </ul>
              </div>
              <input id="workout_id" type="hidden" class="form-control" v-model="workout_id" name="workout_id">
            
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6 offset-md-4">
            <input type="button" name="addworkout" value="Add Workout" v-on:click="addWorkout" class="btn btn-primary">
        </div>
    </div>
   <div class="navbar-item" id="date_picker">
        
    </div>
    <ul class="list-group">
        <li class="list-group-item" v-for="workout in workoutList">{{ workout.name }} <datepicker v-model="date" @selected="saveDate(workout.id)" input-class="input"></datepicker> <a href="#" @click="removeWorkout(workout.id)">X</a></li>
    </ul>
</form>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        props: ['planData'],
        mounted() {
            this.plan_name = this.planData.name;
            this.fetchWorkoutList();
            //console.log('mounted:'+this.plan_name);
            //console.log(this.planData);
        },
        data() {
            return {
                date: new Date(),
                workoutList: [],
                exercises: [],
                exercise: "",
                workout: "",
                query: '',
                results: [],
                workout_id: "",
                plan_name: this.planData.name,
                setdate_workout_id: ""
            };
        },
        components: {
            Datepicker: Datepicker
        },
        watch: {
          date: function(val) {
            axios.post('/api/plans/workout/setdate', {plan_id: this.planData.id, workout_id: this.setdate_workout_id, start_on: val}).then(res => {
                console.log(res.data);
            }).catch(e => {
                console.log(e);
            });
          },
         
        },
        methods: {
            fetchWorkoutList() {
                axios.get('/api/workouts/'+this.planData.id).then((res) => {
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
                if (this.workout_id > 0) {
                    axios.post('/workouts', {name: this.query, workout_id: this.workout_id, plan_id: this.planData.id}).then(res => {
                        this.fetchWorkoutList();
                        this.query = "";
                        this.workout = "";
                        this.workout_id = "";
                        console.log(res.data);
                    }).catch(e => {
                        console.log(e);
                    });
                }
                
                
            },
            removeWorkout(workoutid) {
                axios.post('/api/plans/workout/'+this.planData.id+'/'+workoutid, {_method: 'delete'}).then(res => {
                    this.fetchWorkoutList();
                    console.log(res.data);
                }).catch(e => {
                    console.log(e);
                });
            },
            autoComplete(){
                this.results = [];
                if(this.query.length > 2){
                 axios.get('/api/searchworkout',{params: {query: this.query}}).then(response => {
                  this.results = response.data;
                 });
                }
            },
            suggestionClick(index) {
                this.selection = this.results[index];
                this.query = this.selection.name;
                this.open = false;
                this.results = [];
                this.workout_id = this.selection.id
                console.log(this.selection);
            },
            saveDate(workoutid) {
                this.setdate_workout_id = workoutid;
                //alert('2='+this.date);
                // axios.post('/api/plans/workout/setdate', {plan_id: this.planData.id, workout_id: workoutid, start_on: this.date}).then(res => {
                //         console.log(res.data);
                //     }).catch(e => {
                //         console.log(e);
                //     });
            }
        }
    }
</script>
