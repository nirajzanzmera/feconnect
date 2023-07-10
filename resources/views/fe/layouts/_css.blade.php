<style type="text/css">

    .btn-notification .badge {
        position: absolute;
        top: 5px;
        right: -5px;
        padding: 5px 7px;
        border-radius: 50%;
        background: #bf1c19;
        color: white;
    }
    .navbar-brand img {
        width: 200px;
    }
    @media (max-width: 768px) {
        .navbar-brand img {
            width: 150px;
        }
    }


    i.material-icons:before {
        display: none;
    }

    .hide {
        display: none;
    }

    .also_collapsed {
        margin-left: 60px;
    }

    .sidebar-heading {
        padding: 10px;
    }

    .orange {
        color: #F75734;
    }

    @if($dark ?? false) 
    .card .card-footer,
    .card .card-header {
        background: #5c6c7b;
        color: white;
        font-weight: bold;
    }

    .card-block {
        color: white;
        background: lightslategray;
    }
    .btn-default {
        color: #555555 !important;
    }
    .text-muted {
        color: #eee !important;
    }

    /* .card-block a {
            color: white;
        } */
    .card-block-light {
        color: #424242;
        background: white;
    }

    /* .card-block-light a {
            color: #424242;
        } */
    .card-block label {
        font-weight: bold;
    }

    .thead-dark {
        background: #5c6c7b;
        color: white;
        font-weight: bold;
    }

    .tmp-thumb {
        background: rgb(255, 255, 255, 0.1);
    }

    .q-mark {
        color: white;
    }

    @endif 
    .theme {
        padding: 3px;
        color: lightslategray;
    }

    .theme-active {
        border: solid 1px lightslategray;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        -khtml-border-radius: 3px;
        border-radius: 3px;
    }

    .ellipsis {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    
    [v-cloak] {
        display: none;
    }
    .navbar-nav{ flex-direction: row}
    .navbar-nav .dropdown-menu {
        position: absolute;
    }


    .space-width{ max-width: 400px;min-width: 400px; }
    
    @media (max-width: 768px) {
        .navbar-brand img {
            width: 150px;
        }
    
        .space-width {
            max-width: 380px; 
            min-width: 380px;
        }
    }
    
    @media screen and (min-width:376px) and (max-width:767px){
        .space-width {
            max-width: 380px; 
            min-width: 380px; 
        }
    }
    
    @media screen and (min-width:361px) and (max-width:375px){
        .space-width {
            max-width: 335px; 
            min-width: 335px; 
        }
    }
    
    @media screen and (min-width:321px) and (max-width:360px){
        .space-width {
            max-width: 300px; 
            min-width: 300px; 
        }
    }
    
    @media screen and (max-width:320px) {
        .space-width {
            max-width: 280px; 
            min-width: 280px;
        }
    }
    
</style>
