<?php $view->script('widget-index', 'widget:app/bundle/index.js', ['widgets', 'uikit-nestable']) ?>

<style media="screen">
    .uk-sortable {
        min-height: 50px;
    }
</style>

<div id="widget-index" v-cloak>

    <div class="uk-grid pk-grid-large" data-uk-grid-margin>

        <div class="pk-width-sidebar">
            <div class="uk-panel">

                <ul class="uk-nav uk-nav-side">
                    <li class="uk-visible-hover" v-class="uk-active: active()">
                        <a v-on="click: select()">{{ '- All -' | trans }}</a>
                    </li>
                    <li class="uk-visible-hover" v-class="uk-active: active(p)" v-repeat="p: config.positions" track-by="name">
                        <a v-on="click: select(p)">{{ p.label }}</a>
                    </li>
                </ul>

            </div>
        </div>

        <div class="uk-flex-item-1">

            <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
                <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>

                    <h2 class="uk-margin-remove">{{ position ? position.label : 'All' | trans }}</h2>

                    <div class="uk-margin-left" v-show="selected.length">
                        <ul class="uk-subnav pk-subnav-icon">
                            <li><a class="pk-icon-delete pk-icon-hover" title="{{ 'Delete' | trans }}" data-uk-tooltip="{delay: 500}" v-on="click: remove"></a></li>
                            <li><a class="uk-icon-check-circle-o" title="{{ 'Activate' | trans }}" data-uk-tooltip="{delay: 500}" v-on="click: status(1)"></a></li>
                        </ul>
                    </div>

                    <div class="pk-search">
                        <div class="uk-search">
                            <input class="uk-search-field" type="text" v-model="config.filter.search" debounce="300">
                        </div>
                    </div>

                </div>
                <div data-uk-margin>

                    <div class="uk-button-dropdown" data-uk-dropdown="{ mode: 'click' }">
                        <button class="uk-button uk-button-primary" type="button">{{ 'Add Widget' | trans }}</button>
                        <div class="uk-dropdown uk-dropdown-small">
                            <ul class="uk-nav uk-nav-dropdown">
                                <li v-repeat="type: config.types">
                                    <a href="{{ $url('admin/widget/edit', {type: type.name}) }}">{{ type.name }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="uk-overflow-container">

                <div class="pk-table-fake pk-table-fake-header pk-table-fake-border">
                    <div class="pk-table-width-minimum"><input type="checkbox"  v-check-all="selected: input[name=id]"></div>
                    <div class="pk-table-min-width-100">{{ 'Title' | trans }}</div>
                    <div class="pk-table-width-150">{{ 'Position' | trans }}</div>
                    <div class="pk-table-width-150">{{ 'Type' | trans }}</div>
                </div>

                <div v-repeat="p: positions" track-by="name">

                    <div class="pk-table-fake pk-table-fake-header pk-table-fake-subheading" v-show="positions.length > 1">
                        <div>
                            {{ p.label | trans }}
                            <span class="uk-text-muted" v-if="p.description">{{ p.description | trans }}</span>
                        </div>
                    </div>

                    <ul class="uk-sortable uk-list uk-form" data-uk-sortable="{group:'position', removeWhitespace:false}" data-position="{{ p.name }}">

                        <li v-repeat="id: p.assigned | exists" data-id="{{ id }}" data-index="{{ $index }}">

                            <v-item class="uk-nestable-panel pk-table-fake uk-form" widget="{{ widgets[id] }}" inline-template>
                                <div class="pk-table-width-minimum">
                                    <input type="checkbox" name="id" value="{{ widget.id }}">
                                </div>
                                <div class="pk-table-min-width-100">
                                    <a href="{{ $url('admin/widget/edit', {id: widget.id}) }}" v-if="type">{{ widget.title }}</a>
                                    <span v-if="!type">{{ widget.title }}</span>
                                </div>
                                <div class="pk-table-width-150">
                                    <div class="uk-nestable-nodrag" v-el="select">
                                        <a></a>
                                        <select class="uk-width-1-1" v-model="widget.position" v-on="change: assign(widget.position, widget.id)" options="positionOptions"></select>
                                    </div>
                                </div>
                                <div class="pk-table-width-150">{{ type.name }}</div>
                            </v-item>

                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</div>
