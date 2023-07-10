<style type="text/css">
    .active-plan {
        font-weight: bold;
        border: 2px solid #ddd;
    }

    .table-matrix th,
    .table-matrix td {
        text-align: center;
    }

    .table-matrix td:first-child {
        text-align: right;
    }

    .table-matrix td:nth-child(4),
    .table-matrix th:nth-child(4) {
        font-weight: bold;
        background-color: #eee;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
    }
</style>
<table class="table table-striped table-responsive table-matrix">
    <thead>
        <tr>
            <th></th>
            <th>
                No Plan
            </th>
            <th>
                Basic<br />
                $9.95/mo
            </th>
            <th>
                Pro<br />
                $19.95/mo
            </th>
            <th>
                Deluxe<br />
                $39.95/mo
            </th>
            <th>
                Enterprise<br />
                Call
            </th>
        </tr>
    </thead>
    <tbody>
        @include('subscription.plans._choose')
        <tr>
            <td>Send emails per month from your website</td>
            <td>1000</td>
            <td>2000</td>
            <td>5000</td>
            <td>25000</td>
            <td>Call</td>
        </tr>
        <tr>
            <td>Automatic newsletter generation, scheduling and optimization</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Email-subscription form with list management and monitoring</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Track email performance in real-time</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Preview Website Builder</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Build your own fast and responsive website</td>
            <td>&nbsp;</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Custom Domain Name</td>
            <td>&nbsp;</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Domain Hosting and Domain Renewals </td>
            <td>&nbsp;</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Private Domain Registration</td>
            <td>&nbsp;</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Create personal email addresses with each domain</td>
            <td>&nbsp;</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Content Delivery Network</td>
            <td>&nbsp;</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Secure SSL (https://)</td>
            <td>&nbsp;</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Unlimited Storage</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        <tr>
            <td>Dedicated Account Rep</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>X</td>
            <td>X</td>
            <td>X</td>
        </tr>
        @include('subscription.plans._choose')

    </tbody>
</table>
