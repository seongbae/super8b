<template>
    <table class="table table-sm table-striped">
    <thead>
      <tr>
        <th>Date</th>
        <th>Workout</th>
        <th>Intensity</th>
        <th>Duration</th>
      </tr>
    </thead>
     <tbody>
        <tr v-for="(workout, index) in this.workouts" :key="index">
            <td>{{workout.pivot.start_on | formatDate }}</td>
            <td>
                <a href="#" :id="workout.name+workout.pivot.id" variant="primary">{{workout.name}}</a>
                <b-popover :target="workout.name+workout.pivot.id" triggers="focus">
                  <template v-slot:title>{{workout.name}}</template>
                    <ul id="example-1">
                      <li v-for="exercise in workoutlookups[workout.id].exercises">
                        {{ getActivityName(exercise.name, workout.pivot.repetition, workout.pivot.set) }}
                      </li>
                    </ul>
                </b-popover>
            </td>
            <td>{{workout.intensity}}</td>
            <td>{{workout.duration}}</td>
        </tr>
     </tbody>
  </table>
</template>

<script>
    import moment from 'moment';
    
    export default {
        props: ['workouts','workoutlookups'],
        mounted() {
            console.log('Component mounted.');
            console.log(this.workouts);
            console.log(this.workoutlookups);
        },
        data() {
            return {
            };
        },
        computed: {
            
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
        methods: {
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
