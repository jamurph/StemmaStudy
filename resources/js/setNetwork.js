
let cytoscape = require('cytoscape');
let popper = require('cytoscape-popper');
let tippy = require('tippy.js/dist/tippy-bundle.cjs').default;

let fcose = require('cytoscape-fcose');

cytoscape.use( fcose );

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
                    'border-width': '3px',
                    'border-color': '#28aa80',
                }
            },
            {
                selector: 'edge',
                style: {
                    'width': 3,
                    'line-color': '#6e8789',
                    'target-arrow-color': '#6e8789',
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
                    'color': '#192332'
                }
            }
        ],
        
        /*layout: {
            name: 'breadthfirst',

            fit: true, // whether to fit the viewport to the graph
            directed: false, // whether the tree is directed downwards (or edges can point in any direction if false)
            padding: 20, // padding on fit
            circle: false, // put depths in concentric circles if true, put depths top down if false
            spacingFactor: 1.2, // positive spacing factor, larger => more space between nodes (N.B. n/a if causes overlap)
            boundingBox: undefined, // constrain layout bounds; { x1, y1, x2, y2 } or { x1, y1, w, h }
            avoidOverlap: true, // prevents node overlap, may overflow boundingBox if not enough space
            animate: false, // whether to transition the node positions
            transform: function (node, position ){ return position; } // transform a given node position. Useful for changing flow direction in discrete layouts
        },*/
        /*layout: {
            name: 'cose',
            
            // Number of iterations between consecutive screen positions update
            refresh: 20,
          
            // Whether to fit the network view after when done
            fit: true,
          
            // Padding on fit
            padding: 250,
          
            // Constrain layout bounds; { x1, y1, x2, y2 } or { x1, y1, w, h }
            boundingBox: undefined,
          
            // Excludes the label when calculating node bounding boxes for the layout algorithm
            nodeDimensionsIncludeLabels: true,
          
            // Randomize the initial positions of the nodes (true) or use existing positions (false)
            randomize: true,
          
            // Extra spacing between components in non-compound graphs
            componentSpacing: 40,
          
            // Node repulsion (non overlapping) multiplier
            nodeRepulsion: function( node ){ return 2048; },
          
            // Node repulsion (overlapping) multiplier
            nodeOverlap: 40,
          
            // Ideal edge (non nested) length
            idealEdgeLength: function( edge ){ return 32; },
          
            // Divisor to compute edge forces
            edgeElasticity: function( edge ){ return 32; },
          
            // Nesting factor (multiplier) to compute ideal edge length for nested edges
            nestingFactor: 1.2,
          
            // Gravity force (constant)
            gravity: 1,
          
            // Maximum number of iterations to perform
            numIter: 2000,
          
            // Initial temperature (maximum node displacement)
            initialTemp: 1000,
          
            // Cooling factor (how the temperature is reduced between consecutive iterations
            coolingFactor: 0.99,
          
            // Lower temperature threshold (below this point the layout will end)
            minTemp: 1.0
          },*/
          /*layout : {
            name:'cola',
            animate: true, // whether to show the layout as it's running
            refresh: 1, // number of ticks per frame; higher is faster but more jerky
            maxSimulationTime: 4000, // max length in ms to run the layout
            ungrabifyWhileSimulating: false, // so you can't drag nodes during layout
            fit: true, // on every layout reposition of nodes, fit the viewport
            padding: 30, // padding around the simulation
            boundingBox: undefined, // constrain layout bounds; { x1, y1, x2, y2 } or { x1, y1, w, h }
            nodeDimensionsIncludeLabels: true, // whether labels should be included in determining the space used by a node

            // positioning options
            randomize: true, // use random node positions at beginning of layout
            avoidOverlap: true, // if true, prevents overlap of node bounding boxes
            handleDisconnected: true, // if true, avoids disconnected components from overlapping
            convergenceThreshold: 0.01, // when the alpha value (system energy) falls below this value, the layout stops
            nodeSpacing: function( node ){ return 40; }, // extra spacing around nodes
            
          },*/
          
          layout: {
              name:'fcose',
            quality: "proof",
            // Use random node positions at beginning of layout
            // if this is set to false, then quality option must be "proof"
            randomize: true, 
            // Whether or not to animate the layout
            animate: true, 
            // Duration of animation in ms, if enabled
            animationDuration: 1000, 
            // Easing of animation, if enabled
            animationEasing: undefined, 
            // Fit the viewport to the repositioned nodes
            fit: true, 
            // Padding around layout
            padding: 30,
            // Whether to include labels in node dimensions. Valid in "proof" quality
            nodeDimensionsIncludeLabels: false,
            // Whether or not simple nodes (non-compound nodes) are of uniform dimensions
            uniformNodeDimensions: false,
            // Whether to pack disconnected components - valid only if randomize: true
            packComponents: true,
            
            /* spectral layout options */
            
            // False for random, true for greedy sampling
            samplingType: true,
            // Sample size to construct distance matrix
            sampleSize: 25,
            // Separation amount between nodes
            nodeSeparation: 75,
            // Power iteration tolerance
            piTol: 0.0000001,
            
            /* incremental layout options */
            
            // Node repulsion (non overlapping) multiplier
            nodeRepulsion: 4500,
            // Ideal edge (non nested) length
            idealEdgeLength: 50,
            // Divisor to compute edge forces
            edgeElasticity: 0.45,
            // Nesting factor (multiplier) to compute ideal edge length for nested edges
            nestingFactor: 0.1,
            // Maximum number of iterations to perform
            numIter: 2500,
            // For enabling tiling
            tile: true,  
            // Represents the amount of the vertical space to put between the zero degree members during the tiling operation(can also be a function)
            tilingPaddingVertical: 10,
            // Represents the amount of the horizontal space to put between the zero degree members during the tiling operation(can also be a function)
            tilingPaddingHorizontal: 10,
            // Gravity force (constant)
            gravity: 0.25,
            // Gravity range (constant) for compounds
            gravityRangeCompound: 1.5,
            // Gravity force (constant) for compounds
            gravityCompound: 1.0,
            // Gravity range (constant)
            gravityRange: 3.8, 
            // Initial cooling factor for incremental layout  
            initialEnergyOnIncremental: 0.3,  
          
            /* layout event callbacks */
            ready: () => {}, // on layoutready
            stop: () => {} // on layoutstop
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

});