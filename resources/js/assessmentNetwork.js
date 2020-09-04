
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


/* 
cy.animate(
    { 
        zoom: 2, 
        center: { 
            eles: cy.nodes("[label = 'Time-out']")[0]
        }
    });
*/
$(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
                        edgeElasticity: 0.5,
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