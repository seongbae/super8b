<template>
    <div>
    <button type="submit" class="btn btn-sm" v-bind:class="{ 'btn-danger': user_completed, 'btn-primary': !user_completed}" @click="update_completion">
        <span v-if="user_completed"><i class="fas fa-check"></i> Completed. Great job!</span>
        <span v-if="!user_completed"><i class="fas fa-plus"></i> Mark Complete</span>
    </button>
    <div class="mt-4">
        <div v-for="user in userList">{{ user.name }} completed on {{ formatDate(user.pivot.completed_on) }}</div>
    </div>
</div>
</template>

<script>
    import moment from 'moment';

    export default {
        props: ['user', 'completed', 'planworkoutid'],
        mounted() {
            this.fetchUserCompletedList();
            //console.log('Component mounted.');
            //console.log(this.user);
            //console.log(this.plan);
            //console.log(this.subscribed);
            //moment(String(this.start_on)).format('YYYY-MM-DD 12:00:00')
        },
        data() {
            return {
               user_completed: this.completed,
               userList: {}
            };
        },
        computed: {
            buttonClass: function() {
                return "btn btn-primary btn-sm"
            }
        },
        methods: {
            update_completion: function (event) {
                //alert(this.user_completed);
                this.user_completed = !this.user_completed;
                //alert(this.user_completed);
                axios.post('/api/user/workout/update_status', {id: this.planworkoutid, user_id: this.user.id, completed: this.user_completed }).then(res => {
                            console.log(res.data);
                            this.fetchUserCompletedList();
                        }).catch(e => {
                            console.log(e);
                        });
            },
            fetchUserCompletedList() {
                axios.get('/api/plan/workout/'+this.planworkoutid+'/completed').then((res) => {
                    this.userList = res.data;
                    console.log(res.data);
                });
            },
            formatDate(dt) {
                return moment(String(dt)).format('HH:mm YYYY-MM-DD')
            }
        }
    }
    
</script>
