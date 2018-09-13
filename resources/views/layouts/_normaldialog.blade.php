<div class="modal fade" id="myNormalDialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div style="min-height: 12.5rem;" class="center-dialog">
        <div style="min-height:9rem;width: 100%;text-align: center;padding: 1.5rem;display:table;margin-bottom: 3.5rem;" >
            <p style="display:table-cell; vertical-align:middle;color: #777777;font-size: 1.6rem;">@yield('dialogMsg')</p>
        </div>
        <div class="line-dialog"></div>
        <div class="dialog-single-button" data-dismiss="modal">@yield('buttonText')</div>
    </div>
</div>