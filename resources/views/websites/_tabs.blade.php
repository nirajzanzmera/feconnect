<div class="card">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#simple" name="simple" data-toggle="tab">Simple</a>
            </li>
            <li class="nav-item">

                <a href="#" class="nav-link" id="code_btn">Code</a>
                   
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#preview" name="preview" data-toggle="tab">Previews</a>
            </li>
            
        </ul>
        <div class="tab-content">
            <input v-model="site_data.post.content" type="hidden" name="content" id="content">
            <div class="tab-pane active" id="simple"> 
                <textarea v-model="site_data.post.content" type="text" class="form-control" id="body"  rows="10"></textarea>
            </div>
            <div class="tab-pane" id="code">
                <div id="editor"></div>
                <textarea v-model="site_data.post.content" name="editor"></textarea>
            </div>
            <div class="tab-pane" id="preview">
                <div class="card-block">
                    <div class="btn-group pull-right">
                        <a class="btn btn-default" href="#" id="mobile" title="mobile"><i class="sidebar-menu-icon material-icons">smartphone</i></a>
                        <a class="btn btn-default active" href="#" id="desktop" title="desktop"><i class="sidebar-menu-icon material-icons">desktop_mac</i></a>
                    </div>
                </div>
                <div class="card-block">
                    <div class="embed-responsive embed-responsive-4by3">
                        <div id="return"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
