<template>
    <button type="submit" class="btn btn-sm" v-bind:class="{ 'btn-danger': user_subscribed, 'btn-primary': !user_subscribed}" @click="update_subscription">
        <span v-if="user_subscribed"><i class="fas fa-check"></i> Subscribed</span>
        <span v-if="!user_subscribed"><i class="fas fa-plus"></i> Subscribe</span>
    </button>
</template>

<script>
    export default {
        props: ['user', 'plan', 'subscribed'],
        mounted() {
        },
        data() {
            return {
               user_subscribed: this.subscribed
            };
        },
        computed: {
            buttonClass: function() {
                return "btn btn-primary btn-sm"
            }
        },
        methods: {
            update_subscription: function (event) {
                this.user_subscribed = !this.user_subscribed;
                axios.post('/api/plan/update_subscription', {plan_id: this.plan.id, user_id: this.user.id, subscribe: this.user_subscribed }).then(res => {
                            console.log(res.data);
                        }).catch(e => {
                            console.log(e);
                        });
            }
        }
    }
    
</script>
