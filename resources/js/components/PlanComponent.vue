<template>
    <div class="card">
        <div class="card-header">Edit Workout Plan
            <div class="float-right">
                status: <b-badge :variant="statusClass">{{planStatus}}</b-badge>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form @submit.prevent="savePlan">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" v-model="planName" name="name" placeholder="My Workout Plan" required  autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="notes" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-8">
                                <textarea id="notes" type="text" class="form-control" name="notes" v-model="planDescription"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="goals" class="col-md-4 col-form-label text-md-right">Goal(s):</label>

                            <div class="col-md-8">
                                <input id="goals" type="text" class="form-control" name="goals" v-model="planGoals" placeholder="pass ACFT, lose weight, etc">

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class=" offset-md-4 col-md-6">
                                <button type="submit" class="btn btn-primary ">
                                    Save
                                </button>
                                <input type="button" class="btn btn-primary" :value="planAction" v-on:click="updateStatus()" v-show="showWorkoutAdd"> 
                            </div>
                        </div>
                        
                        <div v-if="showWorkoutAdd">
                            <hr>
                            <h5>Add some workouts to your plan</h5>
                            <div class="form-group row">
                                <label for="workout" class="col-md-4 col-form-label text-md-right">Workout: </label>

                                <div class="col-md-8">
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
                                <label for="date" class="col-md-4 col-form-label text-md-right">Date: </label>

                                <div class="col-md-8">
                                    <datepicker v-model="start_on" format="yyyy-MM-dd" input-class="form-control" :value="today"></datepicker>
                                </div>
                            </div>
                              
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <input type="button" name="addworkout" value="Add Workout" v-on:click="addWorkout" class="btn btn-primary">
                                </div>
                            </div>
                           
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <h5>Workouts in this plan</h5>
                    <ul class="list-group">
                        <li class="list-group-item" v-for="workout in workoutList">{{workout.pivot.start_on | formatDate }} {{ workout.name }} <a href="#" @click="removeWorkout(workout.pivot.id)" class="float-right"><i class="fas fa-minus-circle"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import moment from 'moment';

    export default {
        props: ['userData','planData'],
        mounted() {
            //this.plan_name = this.planData.name;
            if (this.planData)
            {
                this.plan = this.planData;
                this.planName = this.plan.name;
                this.planDescription = this.plan.description;
                this.planGoals = this.plan.goals;
                this.showWorkoutAdd = true;
                this.planStatus = this.plan.status;
                this.fetchWorkoutList();

                if (this.planStatus == 'published')
                    this.planAction = 'Set as Draft'
            }
        },
        data() {
            return {
                start_on: "",
                workoutList: [],
                exercises: [],
                exercise: "",
                workout: "",
                query: "",
                results: [],
                workout_id: "",
                setdate_workout_id: "",
                planName: "",
                planDescription: "",
                planGoals: "",
                plan: "",
                showWorkoutAdd: false,
                planStatus: "draft",
                planAction: "Publish",
                today: new Date()
            };
        },
        components: {
            Datepicker: Datepicker
        },
        filters: {
            formatDate: function(value) {
                  if (value) {
                    return moment(String(value)).format('YYYY-MM-DD');
                  }
                  else
                    return '';
            }
        },
        watch: {
          date: function(val) {
            axios.post('/api/plan/workout/setdate', {plan_id: this.planData.id, workout_id: this.setdate_workout_id, start_on: val}).then(res => {
                console.log(res.data);
            }).catch(e => {
                console.log(e);
            });
          },
         
        },
        computed: {
            planId : {
                get: function() {
                    if (this.planData)
                        return this.planData.id;
                    else
                        return null;
                },
                set: function (val) {
                  //this.planNameData = name;
                }
            },
            statusClass : {
                get: function() {
                    if (this.planStatus == 'draft')
                        return 'secondary'
                    else
                        return 'danger'
                }
            }
            // planAction : {
            //     get: function() {
            //         if (this.planStatus == 'draft')
            //             return 'Publish'
            //         else
            //             return 'Set as Draft'
            //     }
            // }
        },
        methods: {
            fetchWorkoutList() {
                axios.get('/api/workout/'+this.plan.id).then((res) => {
                    this.workoutList = res.data;
                    console.log(res.data);
                });
            },
            savePlan() {
                axios.post('/api/plan', {
                    plan_id: this.planId,
                    name: this.planName,
                    description: this.planDescription,
                    goals: this.planGoals,
                    user_id:this.userData.id
                }).then(res => {
                    this.plan = res.data;
                    this.showWorkoutAdd = true;
                    this.$toasted.global.error('Plan saved');
                }).catch(e => {
                    console.log(e);
                });
                
            },
            addWorkout() {
                if (this.start_on == "") {
                    this.$toasted.global.error('Please add a date');
                    return;
                }

                if (this.workout_id > 0) {
                    axios.post('/api/plan/workout', {
                        workout_id: this.workout_id, 
                        plan_id: this.plan.id, 
                        start_on: moment(String(this.start_on)).format('YYYY-MM-DD 12:00:00')
                    }).then(res => {
                        this.fetchWorkoutList();
                        this.query = "";
                        this.workout = "";
                        this.workout_id = "";
                        this.start_on = "";
                        this.$toasted.global.error('Workout added');
                    }).catch(e => {
                        console.log(e);
                    });
                }
                
                
            },
            removeWorkout(workoutid) {
                axios.post('/api/plan/workout/'+this.planData.id+'/'+workoutid, {_method: 'delete'}).then(res => {
                    this.fetchWorkoutList();
                    this.$toasted.global.error('Workout removed');
                }).catch(e => {
                    console.log(e);
                });
            },
            autoComplete(){
                this.results = [];
                if(this.query.length > 1){
                 axios.get('/api/search/workout',{params: {query: this.query}}).then(response => {
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
            updateStatus() {
                if (this.planStatus == 'draft'){
                    this.publishPlan(this.plan.id)
                }
                else {
                    this.unpublishPlan(this.plan.id)
                }
                
            },
            publishPlan(planid) {
                axios.get('/api/plan/'+this.plan.id+'/publish').then(res => {
                        this.planStatus = 'published';
                        this.planAction = 'Set as Draft';
                        this.$toasted.global.error('Plan published');
                    }).catch(e => {
                        console.log(e);
                    });
            },
            unpublishPlan(planid) {
                axios.get('/api/plan/'+this.plan.id+'/unpublish').then(res => {
                        this.planStatus = 'draft';
                        this.planAction = 'Publish';
                        this.$toasted.global.error('Plan un-published');
                    }).catch(e => {
                        console.log(e);
                    });
            }
        }
    }
</script>
