<template>
    <div v-cloak>
        <div class="form-group">
            <select name="new_email_select_item"  class="form-control" v-model="selected"  @change="handleInput">
                <option selected="selected" value="unselected"></option>
                <option v-for="option in options" v-bind:key="option.index" v-bind:value="option.value">{{ option.label }}</option>
                <option value="new_email">New Email Box...</option>
                <option value="other">Other email</option>
            </select>
        </div>

        <div class="form-group" v-cloak v-if="selected == 'new_email'">
            <form>
                <label for="password" >Enter the password for your new email box:</label>
                <input type="password" class="form-control" v-model="password" placeholder="enter password" autocomplete="current-password" @input="handleInput">
                <label for="password2" v-bind:class="{ 'text-danger': password != password2 }">Confirm Password:</label>
                <input type="password" class="form-control" v-model="password2" placeholder="enter password again" autocomplete="current-password" @input="handleInput">
            </form>
        </div>

        <div class="form-group" v-cloak v-if="selected == 'other'" v-bind:class="{ 'text-danger': errors.email_to !== undefined }">
            <label for="other_email" >Forward to this email:</label>
            <input type="text" class="form-control" v-model="other_email" placeholder="your@email.com" @input="handleInput">
            <span class="help-block" v-if="errors.email_to !== undefined">
                <strong>{{ errors.email_to[0] }}</strong>
            </span>
        </div>

    </div>
</template>

<script>
export default {
  props: ['value','options', 'errors'],
  data: function() {
    return {
      selected: '',
      password: '',
      password2: '',
      other_email: '',
    };
  },
  computed :{
    formData() {
        return {
            selected: this.selected,
            password: this.password,
            password2: this.password2,
            other_email: this.other_email,
        }
    }
  },
  methods: {
    handleInput (e) {
        this.$emit('input', this.formData);
    }
  },
  mounted: function() {
    //this.$emit("input", this.selected);
  }
};
</script>