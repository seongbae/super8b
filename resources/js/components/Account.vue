<template>
  <div>
    <b-card no-body>
      <b-tabs card>
        <b-tab title="My Profile" active>
          <b-card-text>
            <profile></profile>
          </b-card-text>
        </b-tab>
        <b-tab title="Password">
          <b-card-text>
            <password></password>
          </b-card-text>
        </b-tab>
        <b-tab title="Integrations">
          <b-card-text>
            Google Calendar: <a :href="authurl" class="btn btn-primary" v-if="!calendarIntegrated">Integrate</a> <span v-if="calendarIntegrated">Integrated</span> <a href="#" @click="remove_integration()" v-if="calendarIntegrated"><i class="fas fa-minus-circle"></i></a>
          </b-card-text>
        </b-tab>
        <b-tab title="API">
          <b-card-text>
            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>
          </b-card-text>
        </b-tab>
      </b-tabs>
    </b-card>
  </div>
</template>

<script>
export default {
  props: ['userData','authurl'],
  data () {
    return {
      calendarIntegrated: false,
      errors: {},
      submitting: false
    }
  },
  mounted() {
    if (this.userData.gcalendar_integration_active == 1)
      this.calendarIntegrated = true;
  },
  // computed: {
  //       isCalendarIntegrated : {
  //           get: function() {
  //               if (this.workout)
  //                   return this.workout.id;
  //               else
  //                   return null;
  //           },
  //           set: function (val) {
  //             //this.planNameData = name;
  //           }
  //       }
  // },
  methods: {
    remove_integration() {
      axios.post('/api/user/remove_integration', {user_id: this.userData.id})
      .then(response => {
        this.errors = {}
        this.submiting = false
        this.$toasted.global.error('Integration updated!');
        this.calendarIntegrated = false;
      })
      .catch(error => {
        this.errors = error.response.data.errors
        this.submiting = false
      })
    }
  }
}
</script>