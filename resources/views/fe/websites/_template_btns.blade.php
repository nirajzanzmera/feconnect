<fieldset class="form-group">
    <label for="">Insert Templates</label>
    <br />
    <a href="" v-on:click.prevent="tinyInsert(imageLeft)" class="btn btn-default">
        <i class="fa fa-picture-o"></i>
        <i class="fa fa-align-left"></i><br />
        Image left
    </a>
    <a href="" v-on:click.prevent="tinyInsert(imageRight)" class="btn btn-default">
        <i class="fa fa-align-left"></i>
        <i class="fa fa-picture-o"></i><br />
        Image right
    </a>
    <a href="" v-on:click.prevent="tinyInsert(col2)" class="btn btn-default">
        <i class="fa fa-align-left"></i>
        <i class="fa fa-align-left"></i><br />
        2 Columns
    </a>
    <a href="" v-on:click.prevent="tinyInsert(col3)" class="btn btn-default">
        <i class="fa fa-align-left"></i>
        <i class="fa fa-align-left"></i>
        <i class="fa fa-align-left"></i><br />
        3 Columns
    </a>
</fieldset>