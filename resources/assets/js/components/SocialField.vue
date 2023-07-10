<template>
    <div class="row form-group">
        <label :for="name" class="col-md-2 form-control-label" style="text-align: right;">
        <i title="facebook" class="fa fa-facebook"></i></label>
        <div class="col-md-9">
            <input type="text" :dusk="name" :name="name" :placeholder="placeholder" class="form-control">
            <div class="alert alert-warning">
                <p>
                    "{{ asdf }}" looks unusual.<br />
                    Try <a target="_blank" href=""></a> ?
                </p> 
                <a class="btn btn-default">Use Suggestion</a>
            </div>
        </div>
    </div>
</template>

<script>
//import axios from 'axios'
export default {
  props: ["name","placeholder"],
  data: function() {
    return {
      
    };
  },
  methods: {
    
  },
  mounted: function() {

  }
};
</script>
