<template>
  <form class="form-horizontal">
      <div class="form-group row">
        <label class="col-md-3">Current password</label>
        <div class="col-md-9">
          <input class="form-control" :class="{'is-invalid': errors.current}" type="password" v-model="password.current">
          <span class="help-block">You must provide your current password in order to change it.</span>
          <div class="invalid-feedback" v-if="errors.current">{{errors.current[0]}}</div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3">New password</label>
        <div class="col-md-9">
          <input class="form-control" :class="{'is-invalid': errors.password}" type="password" v-model="password.password">
          <div class="invalid-feedback" v-if="errors.password">{{errors.password[0]}}</div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3">Password confirmation</label>
        <div class="col-md-9">
          <input class="form-control" :class="{'is-invalid': errors.password_confirmation}" type="password" v-model="password.password_confirmation">
          <div class="invalid-feedback" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</div>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-md-3"></label>
        <div class="col-md-9">
          <button class="btn btn-primary" type="button" :disabled="submiting" @click="updateAuthUserPassword" >
          <i class="fas fa-spinner fa-spin" v-if="submiting"></i> Save
        </button>
        </div>
      </div>
    </form>
</template>

<script>
export default {
  data () {
    return {
      password: {},
      errors: {},
      submiting: false
    }
  },
  methods: {
    updateAuthUserPassword () {
      this.submiting = true
      axios.put('/api/user/updateAuthUserPassword', this.password)
      .then(response => {
        this.password = {}
        this.errors = {}
        this.submiting = false
        this.$toasted.global.error('Password changed!');
      })
      .catch(error => {
        this.errors = error.response.data.errors
        this.submiting = false
      })
    }
  }
}
</script>