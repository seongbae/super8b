<template>
    <div class="row">
        <div class="col-md-6">
            <form @submit.prevent="saveWorkout" autocomplete="off">
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" v-model="workoutName" placeholder="Lower Body Workout" required  autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="focus" class="col-md-4 col-form-label text-md-right">Focus</label>

                    <div class="col-md-8">
                        <input id="focus" type="text" class="form-control" name="focus" v-model="workoutFocus" placeholder="Upper body, lower body, endurance...">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="focus" class="col-md-4 col-form-label text-md-right">Visibility</label>

                    <div class="col-md-8">
                        <select name="visibility" class="form-control" v-model="workoutVisibility">
                            <option value="private" selected>Private</option>
                            <option value="public">Public</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="notes" class="col-md-4 col-form-label text-md-right">Instructions</label>

                    <div class="col-md-8">
                        <textarea id="notes" type="text" class="form-control" name="notes" v-model="workoutNotes"></textarea>

                    </div>
                </div>
                <div class="form-group row">
                    <label for="notes" class="col-md-4 col-form-label text-md-right"></label>

                    <div class="col-md-8">
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                       <!--  <input type="button" value="Save and Create New" class="btn btn-primary" @click="saveAndCreateNew()">
                        <input type="button" value="Close" class="btn btn-primary" @click="goBack()"> -->
                    </div>
                </div>
                
                <div v-if="showExerciseAdd">
                <hr>
                    <div class="form-group row">
                        <label for="exercise" class="col-md-4 col-form-label text-md-right">Exercise</label>

                        <div class="col-md-8">
                            <input id="exercise" type="text" class="form-control" v-model="query" v-on:keyup="autoComplete" :name="exerciseName" placeholder="Start typing..." autocomplete="new-password">
                            <div class="panel-footer" v-if="results.length">
                               <ul class="list-group">
                                <li class="list-group-item" v-for="(result, index) in results" @click="suggestionClick(index)">
                                 <a href="#">{{ result.name }}</a>
                                </li>
                               </ul>
                              </div>
                              <input id="exercise_id" type="hidden" class="form-control" v-model="exercise_id" name="exercise_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="repetition" class="col-md-4 col-form-label text-md-right">Repetition</label>

                        <div class="col-md-8">
                            <input id="repetition" type="text" class="form-control" name="repetition" v-model="repetition">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sets" class="col-md-4 col-form-label text-md-right">Set</label>

                        <div class="col-md-8">
                            <input id="set" type="number" class="form-control" name="set" v-model="set" min="1" max="100">

                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <input type="button" name="addExercise" value="Add Exercise" v-on:click="addExercise" class="btn btn-primary">
                            </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <div  v-if="exerciseList.length>0">
                <ul class="list-group">
                    <draggable v-model="exerciseList" group="exercise" @start="drag=true" @end="drag=false">
                            <li v-for="exercise in exerciseList" :key="exercise.pivot.id" class="list-group-item" style="cursor: move;" @dragend="updateOrder()">{{getActivityName(exercise.name,exercise.pivot.repetition,exercise.pivot.set)}} <a href="#" @click="removeExercise(exercise.pivot.id)" class="float-right"><i class="fas fa-minus-circle"></i></a></li>
                    </draggable>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    export default {
        props: ['userData','workoutData'],
        components: {
            draggable
        },
        mounted() {

            if (this.workoutData)
            {
                this.workout = this.workoutData;
                this.workout_id = this.workout.id;
                this.workoutName = this.workout.name;
                this.workoutFocus = this.workout.focus;
                this.workoutVisibility = this.workout.visibility;
                this.workoutDuration = this.workout.duration;
                this.workoutIntensity = this.workout.intensity;
                this.workoutNotes = this.workout.notes;
                this.showExerciseAdd = true;
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
                workoutName: "",
                workoutFocus: "",
                workoutVisibility: {},
                workoutDuration: "",
                workoutIntensity: "",
                workoutNotes: "",
                workout: "",
                showExerciseAdd: false,
                workout_id: "",
                exercise_id: "",
                repetition: "",
                set: ""
            };
        },
        computed: {
            openSuggestion() {
                return this.selection !== "" &&
                       this.matches.length != 0 &&
                       this.open === true;
            },
            workoutId : {
                get: function() {
                    if (this.workout)
                        return this.workout.id;
                    else
                        return null;
                },
                set: function (val) {
                  //this.planNameData = name;
                }
            },
            exerciseName : {
                get: function() {
                    return "exercise_"+Date.now();
                }
            }
        },
        methods: {
            fetchExerciseList() {
                axios.get('/api/workout/'+this.workoutId+'/exercises').then((res) => {
                    this.exerciseList = res.data;
                });
            },
            addExercise() {
                if (this.exercise_id > 0) {
                    axios.post('/api/workout/exercise', {
                            workout_id: this.workoutId, 
                            exercise_id: this.exercise_id,
                            repetition: this.repetition,
                            set: this.set,
                        }).then(res => {
                        this.fetchExerciseList();
                        this.query = "";
                        this.repetition = "";
                        this.set = "";
                        this.exercise_id = "";
                        this.$toasted.global.error('Exercise added.');
                        console.log(res.data);
                    }).catch(e => {
                        console.log(e);
                    });
                }
            },
            removeExercise(id) {
                console.log(this.workout);
                axios.post('/api/workout/'+this.workoutId+'/'+id, {_method: 'delete'}).then(res => {
                    this.fetchExerciseList();
                    this.$toasted.global.error('Exercise removed.');
                }).catch(e => {
                    console.log(e);
                });
            },
            saveWorkout() {
                axios.post('/api/workout', {
                        workout_id: this.workoutId, 
                        name: this.workoutName, 
                        focus: this.workoutFocus,
                        intensity: this.workoutIntensity,
                        duration: this.workoutDuration,
                        notes: this.workoutNotes,
                        user_id: this.userData.id,
                        visibility: this.workoutVisibility
                    }).then(res => {
                    this.workout = res.data;
                    this.showExerciseAdd = true;
                    this.$toasted.global.error('Workout updated!');
                }).catch(e => {
                    console.log(e);
                });
                
            },
            saveAndCreateNew() {
                axios.post('/api/workout', {
                        workout_id: this.workoutId, 
                        name: this.workoutName, 
                        focus: this.workoutFocus,
                        intensity: this.workoutIntensity,
                        duration: this.workoutDuration,
                        notes: this.workoutNotes,
                        user_id: this.userData.id
                    }).then(res => {
                    this.workout = res.data;
                    this.showExerciseAdd = true;
                    this.$toasted.global.error('Workout updated!');
                }).catch(e => {
                    console.log(e);
                });
                
            },
            autoComplete(){
                this.results = [];
                if(this.query.length > 1){
                 axios.get('/api/search/exercise',{params: {query: this.query}}).then(response => {
                  this.results = response.data;
                 });
                }
            },
            suggestionClick(index) {
                this.selection = this.results[index];
                this.exercise_id = this.selection.id;
                this.query = this.selection.name;
                this.open = false;
                this.results = [];
                console.log(this.selection);
            },
            updateOrder() {
                axios.post('/api/workout/exercise/update_order', {
                            workout_id: this.workoutId, 
                            exercises: this.exerciseList
                        }).then(res => {
                        //this.fetchExerciseList();
                        
                        console.log(res.data);
                    }).catch(e => {
                        console.log(e);
                    });
              console.log(this.exerciseList);
            },
            goBack() {
              window.history.length > 1 ? this.$router.go(-1) : this.$router.push('/')
            },
            getActivityName(name, rep, set) {
                var setLabel = '';
                var repLabel = '';
                var activityName = '';
                var x = '';

                if (set > 1)
                    setLabel = 'sets';
                else if (set == 1)
                  setLabel = 'set';

                if (rep > 1)
                    repLabel = 'repetitions';
                else if (rep == 1)
                  repLabel = 'repetition';

                if (set && rep)
                  x = ' x ';

                if (!set && !rep)
                  activityName = name;
                else if (!set)
                    activityName =  name + ' ' + rep;
                else
                  activityName =  name + ' ' + set + ' ' + setLabel + x + rep;

                return activityName;
            }
        }
    }
</script>
