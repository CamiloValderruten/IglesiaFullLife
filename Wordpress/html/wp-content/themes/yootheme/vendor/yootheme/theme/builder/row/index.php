<?php

return [

    'name' => 'yootheme/builder-row',

    'builder' => 'row',

    'render' => function ($element) {
        return $this['view']->render('@builder/row/template', compact('element'));
    },

    'events' => [

        'theme.admin' => function () {
            $this['scripts']->add('builder-row', '@builder/row/app/row.min.js', 'customizer-builder');
        }

    ],

    'config' => [

        'title' => 'Row',
        'width' => 500,
        'fields' => [

            'layout' => [
                'label' => 'Layout',
                'title' => 'Select a grid layout',
                'type' => 'select-img',
                'default' => '1-1',
                'options' => [

                    '1-1' => [
                        'label' => 'Whole',
                        'src' => '{+$builder}/row/assets/images/whole.svg',
                    ],
                    ',' => [
                        'label' => 'Halves',
                        'src' => '{+$builder}/row/assets/images/halves.svg',
                    ],
                    ',,' => [
                        'label' => 'Thirds',
                        'src' => '{+$builder}/row/assets/images/thirds.svg',
                    ],
                    ',,,|1-2,1-2,1-2,1-2' => [
                        'label' => 'Quarters',
                        'src' => '{+$builder}/row/assets/images/quarters.svg',
                    ],
                    '2-3,' => [
                        'label' => 'Thirds 2-1',
                        'src' => '{+$builder}/row/assets/images/thirds-2-1.svg',
                    ],
                    ',2-3' => [
                        'label' => 'Thirds 1-2',
                        'src' => '{+$builder}/row/assets/images/thirds-1-2.svg',
                    ],
                    '3-4,' => [
                        'label' => 'Quarters 3-1',
                        'src' => '{+$builder}/row/assets/images/quarters-3-1.svg',
                    ],
                    ',3-4' => [
                        'label' => 'Quarters 1-3',
                        'src' => '{+$builder}/row/assets/images/quarters-1-3.svg',
                    ],
                    '1-2,,|1-1,1-2,1-2' => [
                        'label' => 'Quarters 2-1-1',
                        'src' => '{+$builder}/row/assets/images/quarters-2-1-1.svg',
                    ],
                    ',,1-2|1-2,1-2,1-1' => [
                        'label' => 'Quarters 1-1-2',
                        'src' => '{+$builder}/row/assets/images/quarters-1-1-2.svg',
                    ],
                    ',1-2,' => [
                        'label' => 'Quarters 1-2-1',
                        'src' => '{+$builder}/row/assets/images/quarters-1-2-1.svg',
                    ],
                    'fixed,' => [
                        'label' => 'Fixed-Left',
                        'src' => '{+$builder}/row/assets/images/fixed-left.svg',
                    ],
                    ',fixed' => [
                        'label' => 'Fixed-Right',
                        'src' => '{+$builder}/row/assets/images/fixed-right.svg',
                    ],
                    ',fixed,' => [
                        'label' => 'Fixed-Inner',
                        'src' => '{+$builder}/row/assets/images/fixed-inner.svg',
                    ],
                    'fixed,,fixed' => [
                        'label' => 'Fixed-Outer',
                        'src' => '{+$builder}/row/assets/images/fixed-outer.svg',
                    ],

                ],
            ],

            'columns' => [
                'label' => 'Columns',
                'description' => 'Set a background style or image for each column to create a tile.',
                'type' => 'children',
            ],

            'fixed_width' => [
                'label' => 'Fixed Width',
                'description' => 'Set a fixed column width or expand it to its content\'s width. The other column(s) will automatically fill the remaining space.',
                'type' => 'select',
                'options' => [
                    'Small' => 'small',
                    'Medium' => 'medium',
                    'Large' => 'large',
                    'X-Large' => 'xlarge',
                    'XX-Large' => 'xxlarge',
                    'Auto' => 'auto',
                ],
                'show' => '$match(layout, "fixed")',
            ],

            'gutter' => [
                'label' => 'Gutter',
                'type' => 'select',
                'default' => '',
                'options' => [
                    'Small' => 'small',
                    'Medium' => 'medium',
                    'Default' => '',
                    'Large' => 'large',
                    'Collapse' => 'collapse',
                ],
            ],

            'divider' => [
                'type' => 'checkbox',
                'text' => 'Display dividers between grid cells',
                'show' => 'gutter != "collapse"',
            ],

            'gutter-description' => [
                'description' => 'Set the grid gutter width and display dividers between grid cells.',
                'type' => 'description',
            ],

            'width' => [
                'label' => 'Max Width',
                'description' => 'Set the maximum content width. Note: The section may already have a maximum width, which you cannot exceed.',
                'type' => 'select',
                'default' => '',
                'options' => [
                    'Default' => 'default',
                    'Small' => 'small',
                    'Large' => 'large',
                    'Expand' => 'expand',
                    'None' => '',
                ],
            ],

            'margin' => [
                'label' => 'Margin',
                'description' => 'Set the vertical margin. Note: The first grid\'s top margin and the last grid\'s bottom margin are always removed. Define those in the section settings instead.',
                'type' => 'select',
                'default' => '',
                'options' => [
                    'Keep existing' => '',
                    'Small' => 'small',
                    'Default' => 'default',
                    'Medium' => 'medium',
                    'Large' => 'large',
                    'X-Large' => 'xlarge',
                    'None' => 'remove-vertical',
                ],
            ],

            'vertical_align' => [
                'label' => 'Vertical Alignment',
                'description' => 'Vertically center grid cells.',
                'type' => 'checkbox',
                'text' => 'Center',
            ],

            'match' => [
                'label' => 'Match Height',
                'description' => 'If only one panel element is published inside a column, expand its height to match larger columns.',
                'type' => 'checkbox',
                'text' => 'Match height of single panels',
                'show' => '!vertical_align',
            ],

            'breakpoint' => [
                'label' => 'Breakpoint',
                'description' => 'Set the breakpoint from which grid cells will stack.',
                'type' => 'select',
                'options' => [
                    'None' => '',
                    'Small (Phone Landscape)' => 's',
                    'Medium (Tablet Landscape)' => 'm',
                    'Large (Desktop)' => 'l',
                    'X-Large (Large Screens)' => 'xl',
                ],
            ],

            'order_last' => [
                'label' => 'Order',
                'description' => 'Change the visual order for the last item of the grid. This only applies to the selected breakpoint. When stacked, items will appear in the same order as they do in the source code.',
                'type' => 'checkbox',
                'text' => 'Last item appears first',
            ],

            'id' => '{id}',

            'class' => '{class}',
        ],

        'defaults' => [

            'fixed_width' => 'large',
            'breakpoint' => 'm',

        ],

    ],

];
