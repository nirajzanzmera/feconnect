@extends('fe.layouts.app')

@section('css')
<style>
    .section {
        padding: 15px;
        margin: 5px 0 5px 0;
        border: dashed 1px gray;
    }
    .grab {
        cursor: move;
        cursor: grab;
        cursor: -moz-grab;
        cursor: -webkit-grab;
    }

    .grab:active {
        cursor: grabbing;
        cursor: -moz-grabbing;
        cursor: -webkit-grabbing;
    }
</style>
@endSection


@section('content')
@if((!isset($headless) || (isset($headless) && $headless != true)) and (!isset($hidetitle) || (isset($hidetitle) && $hidetitle != true)))
<div>
    <a href="{{ route('websites.pages.index', $website->id) }}" class="btn btn-default btn-sm pull-right"
        style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h1 class="page-heading">Websites - Pages</h1>
</div>
@endif

@include('fe.websites._nav')

<div id="app">
    {{-- <form action="{{ route('websites.pages.update', ['website'=>$website->id, 'page'=>$page->id, 'type'=>$type]) }}"
    method="POST" id="page_form" ref="page_form">
    {{ method_field('PUT') }}
    {!! csrf_field() !!} --}}

    <div class="row-fluid">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    {{ ucwords($type) ?? 'Page' }} Info: {{ $page->title ?? '' }}
                </div>
                <div class="card-block" v-cloak>
                    <fieldset class="form-group" id="title_group" :class="{ 'has-danger': title_error }">
                        <label for="title" class="post">Title</label>
                        @if(isset($page) && $page->type == 'permanent')
                        <input v-model="site_data.post.title" type="text" class="form-control disabled" name="title"
                            title="This is a special page, and the title is not adjustable" disabled>
                        @else
                        <input v-model="site_data.post.title" type="text" class="form-control" id="title" name="title"
                            placeholder="Enter title" v-on:blur="checkTheTitle()">
                        @endif
                        <span class="form-control-feedback" v-if="title_error">
                            Title is already in use, please use a unique Page Title.
                        </span>
                    </fieldset>

                    <input type="hidden" name="pageInfoAdv" v-model="pageInfoAdv">
                    <a class="btn btn-default btn-sm" v-if="pageInfoAdv == false"
                        v-on:click.prevent="pageInfoAdv = true">
                        <i class="fa fa-plus"></i>
                        More Options
                    </a>
                    <a class="btn btn-default btn-sm" v-if="pageInfoAdv == true"
                        v-on:click.prevent="pageInfoAdv = false" v-cloak>
                        <i class="fa fa-minus"></i>
                        Less Options
                    </a>




                    <div class="page-info" v-if="pageInfoAdv" v-cloak>
                        <hr>
                        <div class="row">
                            @if(!isset($page) || $page->type != 'permanent')
                            <div class="col-md-6">
                                <fieldset class="form-group {{ $errors->has('menu') ? ' has-error' : '' }}">
                                    <label class="post">Select Menu(s) to add {{ $type }} to:</label>
                                    <div class="form-check" v-for="(item, id) in site_data.website_menus">
                                        <input class="form-check-input" type="checkbox" :value="item.id"
                                            v-model="site_data.menus">
                                        <label class="form-check-label">
                                            @{{ item.name }}
                                        </label>
                                    </div>
                                </fieldset>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <fieldset class="form-group{{ $errors->has('start_time') ? ' has-error' : '' }}">
                                <label for="start_time">Publish Date</label>
                                <date-picker v-model="site_data.post.start_time" :config="config"></date-picker>
                                @if ($errors->has('start_time'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('start_time') }}</strong>
                                </span>
                                @endif
                            </fieldset>
                        </div>
                    </div>


                    @if(isset($page) &&( $page->type == 'index' || $page->type == 'permanent'))
                    <fieldset class="form-group">
                        <label for="status">Status</label>
                        <div class="alert alert-info">
                            {{ $page->type == 'index' ? 'The Index page of your website' : 'This confirmation page' }}
                            cannot be deleted or archived.
                        </div>
                    </fieldset>
                    @else
                    <fieldset class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" v-model="site_data.post.status">
                            <option v-for="status in ['live','draft','archived']">
                                @{{ status }}
                            </option>
                        </select>
                        @if ($errors->has('status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('status') }}</strong>
                        </span>
                        @endif
                    </fieldset>
                    @endif

                    @if(!empty(session('home_data')['data']->data->user->admin) && session('home_data')['data']->data->user->admin == true )
                    <fieldset>
                        <label for="scripts">Header Scripts - admin only</label>
                        <textarea name="scripts" id="scripts" class="form-control"
                            v-model="site_data.post.scripts">{{ $page->scripts ?? '' }}</textarea>
                        @if ($errors->has('scripts'))
                        <span class="help-block">
                            <strong>{{ $errors->first('scripts') }}</strong>
                        </span>
                        @endif
                    </fieldset>
                    @endif


                </div>


            </div>
        </div>
    </div>
    <div class="col-md-4">
        @include('websites.pages._actions')
        {{-- @{{ formData }} --}}
    </div>
</div>

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                Edit {{ ucwords($type) ?? 'Page' }}: {{ $page->title ?? '' }}
            </div>
            <div class="card-block">
                <div class="btn-group">
                    {{--  <a class="btn btn-default" v-on:click.prevent="switch_tab('simple')"
                                :class="{ 'btn-primary active': currentTab == 1 }">Simple</a> --}}
                    <a id="edit" class="btn" v-on:click.prevent="switch_tab('advanced')"
                        :class="{ 
                            'btn-primary active': site_data.advanced, 
                            'btn-default': !site_data.advanced
                        }">Edit</a>
                    <a id="preview" class="btn" v-on:click.prevent="switch_tab('preview')"
                        :class="{ 'btn-primary active': currentTab == 3, 'btn-default': currentTab != 3 }">Preview</a>
                </div>
                <hr>

                <div class="tabs">
                    <div class="tab" v-if="currentTab == 1 || currentTab == 2" v-cloak>
                        <div v-if="site_data.advanced == true">
                            <div class="section">
                                <fieldset>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="gallery"
                                            v-model="site_data.showGallery">
                                        {{--                                             <input type="hidden" name="showGallery" v-model="site_data.showGallery"> --}}
                                        <label for="gallery" class="form-check-label">
                                            Gallery Section
                                        </label>
                                    </div>
                                </fieldset>
                                <div v-if="site_data.showGallery">
                                    <textarea name="gallery"
                                        style="width: 1px;height: 1px;opacity: 0;0;">@{{ formData.gallery }}</textarea>

                                    <ul class="list-group">
                                        <draggable v-model="formData.settings.gallery">
                                            <li v-for="(item, index) in formData.settings.gallery" class="list-group-item grab">
                                                <div class="row">
                                                    <div v-if="index == currentItem" class="col-md-12">
                                                        <standalone ref="itemUpdate" v-on:standalone="itemUpdate"
                                                            v-on:close="itemUpdate = false;" :name="index"
                                                            search_url="{{ route('content.images.search') }}"
                                                            downup_url="{{ route('content.downUp') }}"
                                                            imagelist_url="{{ route('content.images.list') }}"
                                                            filelist_url="{{ route('content.images.list', ['show_files'=>true]) }}"
                                                            event_url="{{ route('images.event') }}" folder="{{ $folder }}"
                                                            sig="{{ $sig }}" :image="item.url" :field_name="index">
                                                        </standalone>
                                                    </div>
                                                    <div v-else class="col-md-2">
                                                        <img :src="item.url" alt=""
                                                            style="max-width:150px; max-height:100px;">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div v-if="index == currentItem">
                                                            <fieldset class="form-group">
                                                                <label for="title" class="post">Title</label>
                                                                <input v-model="item.title" type="text" class="form-control"
                                                                    placeholder="Enter title">
                                                            </fieldset>
                                                            <fieldset class="form-group">
                                                                <label for="description" class="post">Description</label>
                                                                <textarea v-model="item.description" name="description"
                                                                    :id="'description' + index"
                                                                    class="form-control"></textarea>
                                                            </fieldset>
                                                            <fieldset class="form-group">
                                                                <label for="button" class="post">Button Text</label>
                                                                <input v-model="item.button" type="text" class="form-control"
                                                                    placeholder="Enter button text">
                                                            </fieldset>
                                                            <fieldset class="form-group">
                                                                <label for="link" class="post">Button Link</label>
                                                                <input v-model="item.permalink" type="text" class="form-control"
                                                                    placeholder="Enter button link">
                                                            </fieldset>
                                                        </div>
                                                        <div v-else>
                                                            <strong>Title:</strong> @{{ item.title }} <br />
                                                            <strong>Button:</strong> <a :href="item.permalink"> @{{ item.button }} </a> <br />
                                                            <strong>Title:</strong> @{{ item.title }} <br />
                                                            <strong>Description:</strong> @{{ item.description }}
                                                            <br />
                                                        </div>
                                                    </div>
                                                    <div class=""
                                                        :class="[ index == currentItem ? 'col-md-4' : 'col-md-2']">
                                                        <div class="btn-group pull-right">
                                                            <a href="" v-if="index != currentItem"
                                                                v-on:click.prevent="editItem(index)"
                                                                class="btn btn-primary">
                                                                <i class="fa fa-edit"></i>
                                                                Edit
                                                            </a>
                                                            <a href="" v-if="index != currentItem"
                                                                v-on:click.prevent="tryDelete(index)"
                                                                class="btn btn-danger">
                                                                <i class="fa fa-trash-o"></i>
                                                                Delete...
                                                            </a>
                                                            <a href="" v-if="index == currentItem"
                                                                v-on:click.prevent="itemSave()" class="btn btn-success">
                                                                <i class="fa fa-check"></i>
                                                                Done
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </draggable>
                                        <li class="list-group-item" style="background:#eee">
                                            <div class="row-fluid">
                                                <div class="col-md-12">
                                                    <standalone ref="newItemImage" v-on:standalone="newItemUpdate"
                                                        v-on:close="showFile = false;" name="newItemImage"
                                                        search_url="{{ route('content.images.search') }}"
                                                        downup_url="{{ route('content.downUp') }}"
                                                        imagelist_url="{{ route('content.images.list') }}"
                                                        filelist_url="{{ route('content.images.list', ['show_files'=>true]) }}"
                                                        event_url="{{ route('images.event') }}" folder="{{ $folder }}"
                                                        sig="{{ $sig }}" :image="newItem.url" field_name="newItemImage">
                                                    </standalone>
                                                </div>
                                                <div class="col-md-8">
                                                    <fieldset class="form-group">
                                                        <label for="title" class="post">Title</label>
                                                        <input v-model="newItem.title" type="text" class="form-control"
                                                            placeholder="Enter title">
                                                            
                                                    </fieldset>
                                                    <fieldset class="form-group">
                                                        <label for="description" class="post">Description</label>
                                                        <textarea v-model="newItem.description" name="description"
                                                            :id="'newItemDescription'" class="form-control"></textarea>
                                                    </fieldset>
                                                    <fieldset class="form-group">
                                                        <label for="button" class="post">Button Text</label>
                                                        <input v-model="newItem.button" type="text" class="form-control"
                                                            placeholder="Enter button text">
                                                    </fieldset>
                                                    <fieldset class="form-group">
                                                        <label for="link" class="post">Button Link</label>
                                                        <input v-model="newItem.permalink" type="text" class="form-control"
                                                            placeholder="Enter button link">
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="" v-on:click.prevent="newItemSave()"
                                                        class="btn btn-success">
                                                        <i class="fa fa-plus"></i>
                                                        Add Item
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="" :class="{ 'section': site_data.advanced }">
                            <legend>Content</legend>

                            <fieldset class="form-group">
                                <label for="image" class="">Featured Image</label>
                                <standalone v-on:standalone="standalone" v-on:close="showFile = false;" name="image"
                                    v-on:remove-image="removeImage"
                                    search_url="{{ route('content.images.search') }}"
                                    downup_url="{{ route('content.downUp') }}"
                                    imagelist_url="{{ route('content.images.list') }}"
                                    filelist_url="{{ route('content.images.list', ['show_files'=>true]) }}"
                                    event_url="{{ route('images.event') }}" folder="{{ $folder }}" sig="{{ $sig }}"
                                    :image="site_data.post.image">
                                </standalone>
                            </fieldset>

                            @include('websites._template_btns')

                            <editor api-key="aegf2fqf84iwno2lab9tv20w19scgxf6v6rcxkzqf180rigs" :init="init"
                                v-model="site_data.post.content" v-cloak></editor>
                        </div>
                    </div>
                    <input type="hidden" name="include_posts" v-model="site_data.post.include_posts">
                    <div v-if="site_data.advanced == true">
                        <div class="section">
                            <fieldset class="form-group">
                                <div class="form-check">
                                    <input v-model="site_data.post.include_posts"
                                        {{--  @change="includePosts($event)" --}} type="checkbox"
                                        class="form-check-input" id="include_posts" value="1">
                                    <label class="form-check-label" for="include_posts">Include Posts</label>
                                </div>
                                <div v-if="site_data.post.include_posts">
                                    <em>Filter Posts by Category</em>

                                    <select class="form-control" v-model="site_data.post.post_category">
                                        <option value="">All Posts</option>
                                        <option v-for="category in site_data.categories" v-bind:value="category.id">
                                            @{{ category.name }}
                                        </option>
                                    </select>


                                    {{-- <select  name="post_category" class="form-control">
                                        <option value="">All Posts</option>
                                        @foreach($categories as $cat)
                                        @if( old('post_category',
                                            (!empty($page->post_category)) ? $page->post_category : '') == $cat->id)
                                        <option value="{{ $cat->id }}" selected>{{ ucwords($cat->name) }}
                                        </option>
                                        @else
                                        <option value="{{ $cat->id }}">{{ ucwords($cat->name) }}</option>
                                        @endif
                                        @endforeach
                                    </select> --}}
                                </div>
                            </fieldset>



                        </div>
                    </div>

                </div>
                <div class="tab" v-if="currentTab == 3" v-cloak>
                    Preview
                    <div class="card-block">
                        <div class="btn-group pull-right">
                            <a :class="{ 'active': preview_type == 'mobile' }" class="btn btn-default"
                                v-on:click.prevent="preview_size('mobile')" title="mobile"><i
                                    class="sidebar-menu-icon material-icons">smartphone</i></a>
                            <a :class="{ 'active': preview_type == 'desktop' }" class="btn btn-default"
                                v-on:click.prevent="preview_size('desktop')" title="desktop"><i
                                    class="sidebar-menu-icon material-icons">desktop_mac</i></a>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="embed-responsive embed-responsive-4by3">
                            {{-- <div id="return">@{{ preview_html }}</div> --}}
                        <iframe name="preview-iframe" class='embed-responsive-item' :style="preview_style"
                            style='border: 1px solid #ddd;' :src="preview_html"></iframe>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<div class="row-fluid">
    <div class="col-md-4">
        @include('websites.pages._actions')
    </div>
</div>
{{-- </form> --}}
</div>

{{-- 
@if($type=='link')
@include('websites.pages._link_form')
@else
@include('websites.pages._form')
@endif
 --}}
@endsection

@section('js')
<script>
    var imageUrl = '{{ route('content.images.list') }}';
    var TemplateUrl = '{{ route('templates.show', $website->template_id) }}';
    var WebsiteDataUrl = '{!! route('websites.data', ['website'=>$website->id, 'page'=>!empty($page) ? $page->id : '', 'template' => !empty($template) ? $template->id : '' ]) !!}';
    @include('websites._templates')
    @include('websites._tiny5_init')
    var crud_type = '{{ $crud_type ?? '' }}';
    var menu_id = {{ $menu_id ?? 0}};
    @if(!empty($crud_type) && $crud_type == 'edit') 
    var title_check_url = '{{ route('websites.pages.title_check', $website->id) }}?page={{ $page->id }}';
    var page_url = '{{ route('websites.pages.update', ['website'=>$website->id, 'page'=>$page->id, 'type'=>$type]) }}';
    var page_url2 = '{{ route('websites.pages.edit', ['website'=>$website->id, 'page'=>$page->id, 'type'=>$type]) }}';
    @else 
    var title_check_url = '{{ route('websites.pages.title_check', $website->id) }}?';
    var page_url = '{{ route('websites.pages.store', ['website'=>$website->id, 'type'=>$type]) }}';
    var page_url2 = '{{ route('websites.pages.index', ['website'=>$website->id]) }}';
    @endif
    var preview_url = '{{ route('website.preview', $website->id) }}';
    var page_image = '{{ $page->image ?? '' }}';
</script>
<script src="{{ mix('/stuff/page_edit.js') }}"></script>

@endsection