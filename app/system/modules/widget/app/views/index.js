module.exports = {

    data: $.extend(true, {
        position: undefined,
        selected: [],
        config: {filter: {}}
    }, window.$data),

    ready: function () {

        var vm = this;

        this.load();

        UIkit.init(this.$el);

        $(this.$el).on('change.uk.sortable', function (e, sortable, element, action) {

            // el = $(el);

            // if (mode == 'moved' || mode == 'added') {

            //     var newpos   = el.parent().data('position'),
            //         newindex = el.index(),
            //         oldpos   = el.data('start-list').data('position'),
            //         oldindex = el.data('start-index');

            //     vm.positions[oldpos].widgets[oldindex].position = newpos;
            //     vm.positions[newpos].widgets.splice(newindex, 0, vm.positions[oldpos].widgets.splice(oldindex, 1)[0]);
            // }

        });
    },

    computed: {

        count: function () {
            return this.widgets.length || '';
        },

        positions: function () {

            if (!this.position) {
                return this.config.positions;
            }

            return [_.find(this.config.positions, 'name', this.position.name)];
        },

        positionOptions: function () {
            return [{text: this.$trans('- Assign -'), value: ''}].concat(
                _.map(this.config.positions, function (position) {
                    return {text: this.$trans(position.label), value: position.name};
                }.bind(this))
            );
        }

    },

    methods: {

        active: function (position) {

            if (!position) {
                return this.position === position;
            }

            return this.position && this.position.name === position.name;
        },

        select: function (position) {
            this.$set('position', position);
        },

        assign: function (position, ids) {
            this.resource.save({id: 'assign'}, {position: position, ids: ids}, function (data) {
                this.config.$set('positions', data.positions);
            });
        }

    },

    filters: {

        exists: function (ids) {
            return ids.filter(function (id) {
                return this.widgets[id] !== undefined;
            }.bind(this));
        }

    },

    components: {

        'v-item': {

            inherit: true,

            props: ['widget'],

            computed: {

                type: function () {
                    if (this.widget) {
                        return _.find(this.config.types, {name: this.widget.type});
                    }
                }

            }

        }

    }

};

$(function () {

    (new Widgets(module.exports)).$mount('#widget-index');

});
