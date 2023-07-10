<div class="card-block">
    @if(!empty($campaign))
    <div class="btn-group">
        @if(!empty($campaign->schid) && $campaign->schid->status != 'sent' && $campaign->status != 'locked')
        <button type="submit" class="btn btn-default" value="Save Draft" title="Save Draft">
            <i class="fa fa-file"></i> Save Draft
        </button>
        @endif
        <div class="btn-group">
            <div class="dropdown show">
                <a class="btn btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-file"></i> Save As...
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item save_as_email" href="#"><i class="fa fa-envelope"></i> New Email</a>
                    <a class="dropdown-item save_as_template" href="#"><i class="fa fa-puzzle-piece"></i> New
                        Template
                    </a>
                </div>
            </div>
        </div>
        <a href="{{ route('campaigns.publish_preview', $id) }}" class="btn btn-success schedule-btn"
            title="Schedule Send">
            <i class="fa fa-calendar"></i>
            Schedule Send
        </a>
    </div>

    @else
    <div class="btn-group">
        <button type="submit" class="btn btn-default" title="Save Draft">
            <i class="fa fa-file"></i> Save
        </button>
        <a href="#" class="btn btn-success save_and_sched" title="Schedule Send">
            <i class="fa fa-calendar"></i> Schedule Send
        </a>
    </div>
    @endif
</div>
