<template>
    <button type="submit" class="btn btn-sm" v-bind:class="{ 'btn-danger': user_completed, 'btn-primary': !user_completed}" @click="update_completion">
        <span v-if="user_completed"><i class="fas fa-check"></i> Completed. Great job!</span>
        <span v-if="!user_completed"><i class="fas fa-plus"></i> Mark Complete</span>
    </button>
</template>

<script>
    export default {
        props: ['user', 'completed', 'planworkoutid'],
        mounted() {
            //console.log('Component mounted.');
            //console.log(this.user);
            //console.log(this.plan);
            //console.log(this.subscribed);
        },
        data() {
            return {
               user_completed: this.completed
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
                        }).catch(e => {
                            console.log(e);
                        });
            }
        }
    }
    
</script>
