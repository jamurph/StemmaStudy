
let cytoscape = require('cytoscape');
let popper = require('cytoscape-popper');

let fcose = require('cytoscape-fcose');

cytoscape.warnings(false);

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
            }
        ],
        layout: {
            name:'preset',
            animate: true,
            animationDuration: 1000,
            animationEasing: 'ease-in-out',
            stop: function(){
                if(has_new_cards){
                    //change message on popup
                    $('#loader-message').text('Shifting for new cards...')
                    cy.layout({
                        name:'fcose',
                        quality: "proof",
                        randomize: false, 
                        animate: true,
                        animationDuration: 1000,
                        fit: true, 
                        padding: 30,
                        nodeDimensionsIncludeLabels: true,
                        uniformNodeDimensions: false,
                        nodeSeparation: 250,
                        nodeRepulsion: 4579,
                        idealEdgeLength: 71, 
                        edgeElasticity: 0.2,
                        nestingFactor: 0.1,
                        numIter: 2500,
                        stop: function(){
                            $('#loader').fadeOut();
                            var changes = [];
                            var nodes = cy.nodes();
                            for(var i = 0; i < nodes.length; i++){
                                element = nodes[i];
                                changes.push({
                                    card_id: element.data('card_id'), position: element.position()
                                });
                            }
                            changes = {changes: changes};
                            $.ajax({
                                method: "PUT",
                                url :'/network/' + set_id + '/update/',
                                data: JSON.stringify(changes),
                                contentType: "application/json"
                            });
                        }
                    }).start();
                } else {
                    $('#loader').fadeOut();
                }
                
            }
        },
        wheelSensitivity: 0.25,
        maxZoom: 2.5,
        minZoom: 0.1,
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
                
                $(div).addClass('network-detail').addClass('shadow').css('width', '500px').css('max-width', 'calc(100% - 10px)').css('z-index', '100001');
                $(div).html('<div class="close"><i class="fas fa-times"></i></div><h3 class="mb-0 pr-3">' + node.data('label') + '</h3><hr>' + '<div class="card-definition text-muted mb-0">' + node.data('definition') + '</div>'
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    cy.on('dragfreeon', 'node', function(event){
        element = event.target;
        if(!element){
            return;
        }
        
        var changes = {changes:[{ card_id: element.data('card_id'), position: element.position() }]};

        $.ajax({
            method: "PUT",
            url :'/network/' + set_id + '/update/',
            data: JSON.stringify(changes),
            contentType: "application/json"
        });
    });

});