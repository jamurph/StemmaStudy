
let cytoscape = require('cytoscape');
let popper = require('cytoscape-popper');
let tippy = require('tippy.js/dist/tippy-bundle.cjs').default;

cytoscape.use( popper ); // register extension

$(function(){

    var cy = cytoscape({
        
        container: $('#network'), // container to render in
        
        elements: network_elements,
        
        style: [ // the stylesheet for the graph
            
            {
                selector: 'node',
                style: {
                    'background-color': '#fff',
                    'label': 'data(label)',
                    'width': '250px',
                    'height': 'label',
                    'padding' : '10px',
                    'shape' : 'round-rectangle',
                    'border-width': '2px',
                    'border-color': '#97B18B'
                }
            },
            {
                selector: 'edge',
                style: {
                    'width': 2,
                    'line-color': '#65738D',
                    'target-arrow-color': '#65738D',
                    'target-arrow-shape': 'triangle',
                    'curve-style': 'bezier'
                }
            },
            {
                selector: 'node[label]',
                style: {
                    'text-halign': 'center',
                    'text-valign': 'center',
                    'text-wrap' : 'wrap',
                    'text-max-width': '250px',
                    'text-justification': 'left',
                    'color': '#333'
                }
            }
        ],
        
        layout: {
            name: 'breadthfirst',

            fit: false, // whether to fit the viewport to the graph
            directed: false, // whether the tree is directed downwards (or edges can point in any direction if false)
            padding: 30, // padding on fit
            circle: true, // put depths in concentric circles if true, put depths top down if false
            spacingFactor: 1.2, // positive spacing factor, larger => more space between nodes (N.B. n/a if causes overlap)
            boundingBox: undefined, // constrain layout bounds; { x1, y1, x2, y2 } or { x1, y1, w, h }
            avoidOverlap: true, // prevents node overlap, may overflow boundingBox if not enough space
            animate: false, // whether to transition the node positions
            transform: function (node, position ){ return position; } // transform a given node position. Useful for changing flow direction in discrete layouts
        },
        wheelSensitivity: 0.25,
        zoom: 0.7,
    });

    cy.on('mouseover', 'edge', function(event){
        var edge = event.target;

        let ref = edge.popperRef({
            renderedPosition: () => (event.renderedPosition)
        });

        let dummyDomEle = document.createElement('div');

        edge.tip = tippy(dummyDomEle, { 
            trigger: 'manual',
            lazy: false, 
            onCreate: instance => { instance.popperInstance.reference = ref; },
            content: () => {
                let content = document.createElement('div');

                content.innerHTML = edge.data('label');

                return content;
            },
            arrow: false,
            distance: 0
        });

        edge.tip.show();

    });

    cy.on('mouseout', 'edge', function(event){
        var edge = event.target;
        
        if(edge.hasOwnProperty("tip") && edge.tip !== undefined && edge.tip !== null){
            edge.tip.destroy();
        }
    });


    cy.on('mouseover', 'node', function(e){
        $('#network').addClass('mouse-over');
    });
    cy.on('mouseout', 'node', function(e){
        $('#network').removeClass('mouse-over');
    });

    cy.on('vclick', 'node', function(e){
        window.location = '/card/' + e.target.data('id').substring(5);
    });



    /********EXPORT*******/
    $('.export').click(function(){ 
        $('.modal-json').text(JSON.stringify(cy.json(), null, "\t"));
        $('.modal').modal('show');
    });

});