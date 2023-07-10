<div class="card card-default">
    <div class="card-header">
        Page Actions
    </div>
    <div class="card-block">
        <div style="width: 1px;height: 1px;opacity: 0;0;">
            @{{ shouldWePrevent }}@{{ shouldPrevent }}
        </div>
        <button type="button" v-on:click.prevent="submitData()" {{-- v-if="!submit_disabled" --}} :disabled="submit_disabled"
            class="btn btn-success submit_data" v-cloak>
            <i class="fa fa-save"></i>
            {{ Route::currentRouteName() == 'websites.pages.create' ? 'Create' : 'Update' }}
        </button>
        <div v-if="updateMsg" class="alert alert-success">
            Page updated
        </div>
    </div>
</div>