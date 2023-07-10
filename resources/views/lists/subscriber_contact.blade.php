@extends('fe.layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Contact - {{ $subscriber->email }}</h1>
    @include('lists._nav')
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('lists.index') }}">Lists</a></li>
    <li class="active">Subscriber</li>
</ol>

<div class="row-fluid">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Contact - {{ $subscriber->email }}</h4>
                        <p class="card-subtitle"><i>Subscribed on {{ $subscriber->subscribe_stamp }}</i></p>
                    </div>
                </div>
            </div>
            
            <div class="card-block" id="information">
                <form method="post" action="https://connect.dataczar.com/lists/subscriber/4786580/update">
                    <input type="hidden" name="_token" value="YyHKYRerWHCmeOQlpK3NbhILYja3TFNCbBEWxWaz">
                    <div class="row form-group ">
                        <label class="col-md-3">Name:</label>
                        <div class="col-md-9">
                            <input v-if="editName" @keyup.enter="editName=false" type="text" class="form-control" name="" placeholder="">
                            <a @click.prevent="editName=true" v-if="!editName" href="#" class="btn btn-sm btn-primary">Edit</a>
                        </div>
                    </div>
                    <div class="row form-group ">
                        <label class="col-md-3">Phone:</label>
                        <div class="col-md-9">
                            <input v-if="editPhone" @keyup.enter="editPhone=false" type="text" class="form-control" name="" placeholder="">
                            <a @click.prevent="editPhone=true" v-if="!editPhone" href="#" class="btn btn-sm btn-primary">Edit</a>
                        </div>
                    </div>
                    <div class="row form-group ">
                        <label class="col-md-3">Email:</label>
                        <div class="col-md-9">
                            <a href="malito:{{$subscriber->email}}">{{$subscriber->email}}</a>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3">Status:</label>
                        <div class="col-md-6">
                            <span v-if="!editStatus">{{$subscriber->status}}</span>
                            <select v-if="editStatus" name="status" class="form-control">
                                <option value="active" {{$subscriber->status == 'active' ? 'selected' : ''}}>Active</option>
                                <option value="unsubscribe" {{$subscriber->status == 'unsubscribe' ? 'selected' : ''}}>Unsubscribed</option>
                            </select>
                        </div>
                        <a @click.prevent="editStatus=true" v-if="!editStatus" href="#" class="btn btn-sm btn-primary">Edit</a>
                        <a @click.prevent="editStatus=false" v-if="editStatus" href="#" class="btn btn-sm btn-danger">Cancel</a>

                    </div>
                    <div class="row form-group">
                        <label class="col-md-2">List:</label>
                        <div class="col-md-6">
                            <span>List default</span>
                        </div>
                        <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Add list</a>
                        <a href="#" class="btn btn-sm btn-primary">Edit</a>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-3">Tags:</label>
                        <div class="col-md-9">
                            <span>site:YogurtConcoction.com</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                    <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Add Tag</a>

                    <div v-if="moreInformation" class="mt-3">

                        <h5 class="font-weight-bold">More information:</h5>
                        <div class="row form-group">
                            <label class="col-md-12">Facebook:
                                <span>fb.com/yogurtconcoction.com</span>
                            </label>
                        </div>
                        <div v-if="addInformation">
                            <div class="row form-group">
                                <label class="col-md-4">Social:</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="" id="" placeholder="">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4">Address:</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="" id="" placeholder="">
                                </div>
                            </div>
                        </div>
                        
                        <a @click.prevent="addInformation=!addInformation" href="#" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus-circle"></i> Add Information
                        </a>
                        <div class="form-group">
                          <textarea class="form-control" name="" placeholder="Add contact notes" id="" rows="3"></textarea>
                          <div class="d-flex justify-content-end">
                              <button class="btn btn-primary text-right">Update Notes</button>
                          </div>
                        </div>
                        <h5 class="font-weight-bold mt-1">Research Tools</h5>
                        <p class="font-italic">Learn more about your contacts</p>
                        <p>Google | Lullar </p>
                    </div>
                    <div class="row justify-content-center form-group">
                            <a @click.prevent="moreInformation=false" v-if="moreInformation" href="#" class="btn btn-default text-center">Less</a>
                            <a @click.prevent="moreInformation=true" v-if="!moreInformation" href="#" class="btn btn-default text-center">More</a>
                    </div>
                </form>
            </div>
            
        </div>

        <div class="card">
            <div class="card-header">
                Subscriber Data
            </div>
            <ul class="list-group list-group-flush ">
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: left">
                        Source: 
                    </div>
                    <div class="col-xs-9">
                        {{ $subscriber->source ?? '' }}
                    </div>
                </li>
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: left">
                        Subscribed On: 
                    </div>
                    <div class="col-xs-9">
                        {{ $subscriber->subscribe_stamp }}
                    </div>
                </li>
                <li class="list-group-item row">
                    <div class="col-xs-12" style="text-align: left">
                        IP: 98.24.27.138 | Country: US | City: Gastonia | State: GA
                    </div>
                    
                </li>
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: left">
                        Last Send: 
                    </div>
                    <div class="col-xs-9">
                        {{ $subscriber->subscribe_stamp }}
                    </div>
                </li>
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: left">
                        Last Open:
                    </div>
                    <div class="col-xs-9">
                        {{ $subscriber->last_open_stamp }}
                    </div>
                </li>
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: left">
                        Last Click:
                    </div>
                    <div class="col-xs-9">
                        {{ $subscriber->last_click_stamp }}
                    </div>
                </li>
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: left">
                        Last IP:
                    </div>
                    <div class="col-xs-9">
                        76.21.220.80 | Country: US |
                    </div>
                </li>
                <li class="list-group-item row">
                    <div class="col-xs-3" style="text-align: left">
                        City:
                    </div>
                    <div class="col-xs-9">
                        Columbia | State: CA
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-6 ">
        <div class="card">
            <div class="card-header">
                Recent Updates
            </div>
            <div class="form-group">
                <textarea class="form-control" name="" placeholder="Add an update" id="" rows="3"></textarea>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary text-right"><i class="fa fa-plus"></i>Add Note</button>
                </div>
            </div>
            <div class="card-block">
                <div class="row pb-2">
                    <div class="col-xs-4" style="text-align: left">
                        12/14/20 11:42 AM 
                    </div>
                    <div class="col-xs-8">
                        Contact opened "Subject of email"
                        <button class="btn btn-primary btn-sm">view</button>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-xs-4" style="text-align: left">
                        12/14/20 09:40 AM 
                    </div>
                    <div class="col-xs-8">
                        Sent email "Subject of email"
                        <button class="btn btn-primary btn-sm">view</button>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-xs-4" style="text-align: left">
                        7/15/20 12:15 PM 
                    </div>
                    <div class="col-xs-8">
                        Note: "Talked to customer about newsletter."
                        <button class="btn btn-primary btn-sm">edit</button>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-xs-4" style="text-align: left">
                        6/9/20 09:51 AM 
                    </div>
                    <div class="col-xs-8">
                        Clicked "first email"
                        <button class="btn btn-primary btn-sm">view</button>
                        to link
                        <button class="btn btn-primary btn-sm">copy link</button>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-xs-4" style="text-align: left">
                        6/9/20 09:50 AM 
                    </div>
                    <div class="col-xs-8">
                        Opened "first email"
                        <button class="btn btn-primary btn-sm">view</button>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-xs-4" style="text-align: left">
                        6/9/20 09:45 AM 
                    </div>
                    <div class="col-xs-8">
                        Sent email "first email."
                        <button class="btn btn-primary btn-sm">view</button>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-xs-4" style="text-align: left">
                        6/9/20 09:29 AM 
                    </div>
                    <div class="col-xs-8">
                        added tag list:default
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-xs-4" style="text-align: left">
                        6/9/20 09:29 AM 
                    </div>
                    <div class="col-xs-8">
                        Contact subscribed to "default" email list using Newsletter Sign Up on https://www.yogurtconcoction.com/index.html with IP 50.113.87.228.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.js"></script>

<script type="text/javascript">
    var app = new Vue({
        el: '#information',
        data () {
            return {
                'editName': false,
                'editPhone': false,
                'editStatus': false,
                'addInformation': false,
                'moreInformation': true,
            }
        },
        methods: {
            
        },
        mounted() {

        },
    })
</script>
@endsection
@section('css')
    <style>
        .h-card {
            height: 300px;
        }
        .flex-wrap {
            flex-wrap: wrap;
        }
        .progress {
            display: -ms-flexbox;
            display: flex;
            height: 1rem;
            overflow: hidden;
            font-size: .75rem;
            background-color: #5e1616;
            border-radius: .25rem;
        }
        .border-orange {
            border: 2px solid orange!important;
            height: fit-content;
        }
        .media-icon {
            margin-left: .5rem!important;
            margin-right: .5rem!important;
            padding: 1rem!important;
            position: relative;
        }
        .media-icon .lock {
            opacity: 0.6;
            font-size: 3em;
        }
        .media-icon .fa-lock {
            position: absolute;
            left: 28px;
            transform: rotateZ(30deg);
            font-size: 2.6em;
        }
    </style>   
@endsection