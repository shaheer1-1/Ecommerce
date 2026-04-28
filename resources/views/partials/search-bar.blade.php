@php
    $searchInputName = $searchParam ?? 'search';
@endphp
<div class="{{ $colClass ?? 'col-lg-6 col-12' }}">
    <div class="{{ $alignment ?? 'row' }}">
        <div class="{{ $fullWidthSearchClass ?? 'col-lg-7 col-md-9 mb-md-0 mb-3 ml-auto' }}">
            <form action="{{ $action ?? '' }}" method="get" class="{{ $formStyle ?? '' }}">
                <div class="search-bar">
                    <div class="input-group input-group-merge">
                        <input type="text" class="form-control" placeholder="{{ $placeholder ?? 'Search by name' }}" aria-label="Search..." aria-describedby="basic-addon-search31" name="{{ $searchInputName }}" value="{{ $search ?? request($searchInputName, '') }}">
                        <button class="input-group-text search-icon" id="basic-addon-search31" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
