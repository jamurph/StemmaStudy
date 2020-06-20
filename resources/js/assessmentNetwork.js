
let cytoscape = require('cytoscape');
let popper = require('cytoscape-popper');

let fcose = require('cytoscape-fcose');

cytoscape.use( fcose );

cytoscape.use( popper ); // register extension


let popperInstance = null;
let fitMaxZoom = 2.5;

function destroyPopper(){
    if(popperInstance) {
        popperInstance.destroy();
        $(popperInstance.popper).remove();
        popperInstance = null;
    }
}


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
            },
            {
                selector: 'node[score >= 0]',
                style: {
                    'border-color': '#e3342f',
                }
            },
            {
                selector: 'node[score >= 2.5]',
                style: {
                    'border-color': '#e54631',
                }
            },
            {
                selector: 'node[score >= 7.5]',
                style: {
                    'border-color': '#e85834',
                }
            },
            {
                selector: 'node[score >= 12.5]',
                style: {
                    'border-color': '#eb6b37',
                }
            },
            {
                selector: 'node[score >= 17.5]',
                style: {
                    'border-color': '#ee7e39',
                }
            },
            {
                selector: 'node[score >= 22.5]',
                style: {
                    'border-color': '#f1903c',
                }
            },
            {
                selector: 'node[score >= 27.5]',
                style: {
                    'border-color': '#f3a33f',
                }
            },
            {
                selector: 'node[score >= 32.5]',
                style: {
                    'border-color': '#f6b541',
                }
            },
            {
                selector: 'node[score >= 37.5]',
                style: {
                    'border-color': '#f9c844',
                }
            },
            {
                selector: 'node[score >= 42.5]',
                style: {
                    'border-color': '#fcda47',
                }
            },
            {
                selector: 'node[score >= 47.5]',
                style: {
                    'border-color': '#ffed4a',
                }
            },
            {
                selector: 'node[score >= 52.5]',
                style: {
                    'border-color': '#ebe84e',
                }
            },
            {
                selector: 'node[score >= 57.5]',
                style: {
                    'border-color': '#d7e452',
                }
            },
            {
                selector: 'node[score >= 62.5]',
                style: {
                    'border-color': '#c3df56',
                }
            },
            {
                selector: 'node[score >= 67.5]',
                style: {
                    'border-color': '#afdb5a',
                }
            },
            {
                selector: 'node[score >= 72.5]',
                style: {
                    'border-color': '#9bd75e',
                }
            },
            {
                selector: 'node[score >= 77.5]',
                style: {
                    'border-color': '#87d262',
                }
            },
            {
                selector: 'node[score >= 82.5]',
                style: {
                    'border-color': '#73ce66',
                }
            },
            {
                selector: 'node[score >= 87.5]',
                style: {
                    'border-color': '#5fc96a',
                }
            },
            {
                selector: 'node[score >= 92.5]',
                style: {
                    'border-color': '#4bc56e',
                }
            },
            {
                selector: 'node[score >= 97.5]',
                style: {
                    'border-color': '#38c172',
                }
            },
            {
                //undefined
                selector: 'node[score < 0]',
                style: {
                    'border-color': '#cccccc',
                }
            }
        ],
         
        
          
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
            // Fit the viewport to the repositioned nodes
            fit: true, 
            // Padding around layout
            padding: 30,
            // Whether to include labels in node dimensions. Valid in "proof" quality
            nodeDimensionsIncludeLabels: true,
            // Whether or not simple nodes (non-compound nodes) are of uniform dimensions
            uniformNodeDimensions: false,
            // Whether to pack disconnected components - valid only if randomize: true
            packComponents: true,
            
            // Separation amount between nodes
            nodeSeparation: 250,
            
            // Node repulsion (non overlapping) multiplier
            nodeRepulsion: 4500,
            // Ideal edge (non nested) length
            idealEdgeLength: 70,
            // Divisor to compute edge forces
            edgeElasticity: 0.2,
            // Nesting factor (multiplier) to compute ideal edge length for nested edges
            nestingFactor: 0.1,
            // Maximum number of iterations to perform
            numIter: 2500,
            
          },
         
        wheelSensitivity: 0.25,
        maxZoom: 2.5,
        minZoom: 0.2,
    });

    cy.on('vclick', 'edge', function(event){
        var edge = event.target;

        destroyPopper();

        popperInstance = edge.popper({
            content: () => {
                let div = document.createElement('div');

                $(div).addClass('network-detail').addClass('shadow').css('width', '500px').css('max-width', 'calc(100% - 10px)').css('z-index', '100001');
                $(div).html('<div class="close"><i class="fas fa-times"></i></div><a class="text-decoration-none mb-2 pr-3" href="/my-sets/' + set_id + '/card/' + edge.source().data('card_id') + '">' + edge.source().data('label') + '</a>'
                    + '<h3 class="mb-0"><i class="fas fa-angle-double-right"></i> ' + edge.data('label') + ' <i class="fas fa-angle-double-right"></i></h3>' + '<p class="has-newlines text-muted mb-0">' + edge.data('description') + '</p>'
                    + '<a class="text-decoration-none mt-2" href="/my-sets/' + set_id + '/card/' + edge.target().data('card_id') + '">' + edge.target().data('label') + '</a>'
                    );
                document.body.appendChild(div);
            
                $('.close').click(function(){
                    destroyPopper();
                });

                return div;
              },
              popper: {

              }
        });
    });

    cy.on('mouseover', 'node,edge', function(e){
        $('#network').addClass('mouse-over');
    });
    cy.on('mouseout', 'node,edge', function(e){
        $('#network').removeClass('mouse-over');
    });

    cy.on('vclick', 'node', function(e){
        var node = e.target;
        destroyPopper();

        popperInstance = node.popper({
            content: () => {
                let div = document.createElement('div');
                
                let score = node.data('score');
                let scoreHtml = '';
                if(score != -1){
                    scoreHtml = ' <span class="score_color_' + (Math.round(score / 5 ) * 5)  +'"><b>' + score + '</b></span>';
                }

                $(div).addClass('network-detail').addClass('shadow').css('width', '500px').css('max-width', 'calc(100% - 10px)').css('z-index', '100001');
                $(div).html('<div class="close"><i class="fas fa-times"></i></div><h3 class="mb-0 pr-3">' + node.data('label') + scoreHtml + '</h3><hr>' + '<div class="card-definition text-muted mb-0">' + node.data('definition') + '</div>'
                    + '<div class="text-right"><a class="btn btn-link text-decoration-none" href="/my-sets/' + set_id + '/card/' + node.data('card_id') + '"><span class="pr-2">View Details</span><i class="fas fa-angle-double-right"></i></a></div>'
                );
                
                document.body.appendChild(div);

                $('.close').click(function(){
                    destroyPopper();
                });
            
                return div;
              },
              popper: {

              }
        });
    });

    cy.on('vclick pan zoom', function(event){
        if(event.target === cy){
            destroyPopper();
        }
    });

});