<div class="col-md-12 d-flex justify-content-end">
    <button type="button" class="btn btn-outline-success w-100" id="username_check_button"
        onclick="checkId('{{ $game->slug }}')">
        <div id="username_loading" class="spinner-border" role="status" style="display:none;">
            <span class="visually-hidden"></span>
        </div>
        <div id="nickname_text">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                <path d="M21 21l-6 -6" />
            </svg>
            Cek ID
        </div>
    </button>
</div>
