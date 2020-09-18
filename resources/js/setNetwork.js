let cytoscape = require('cytoscape');
let popper = require('cytoscape-popper');

let fcose = require('cytoscape-fcose');

cytoscape.warnings(false);

cytoscape.use( fcose );

cytoscape.use( popper ); // register extension


let popperInstance = null;
let reallyDelete = false;

function destroyPopper(){
    if(popperInstance) {
        popperInstance.destroy();
        $(popperInstance.popper).remove();
        popperInstance = null;
    }
}

function closeMenu(){
    $('.side-menu').css({"transform": "translate(-100%,0)"});
    $('.side-menu').removeClass('shadow-lg');
}

function openMenu(){
    destroyPopper();
    $('.side-menu').css({"transform": "translate(0,0)"});
    $('.side-menu').addClass('shadow-lg');
}

function closeSearch(){
    $('.search-container').fadeOut();
    $('#search-text').val('');
}

function openSearch(){
    destroyPopper();
    closeConnection();
    $('.search-result div').addClass('visible');
    $('.search-container').fadeIn();
    $('#search-text').focus();
}

function clearConnectionForm(){
    $('.is-invalid').removeClass('is-invalid');
    $('#newSelect').attr('disabled', false);
    $('#newSelect').removeClass('disabled');
    $('#newSelect').val('').change();
    $('input[name=newDirection]').val(['to']);
    $('#newFrom').attr('disabled', false);
    $('#newFrom').removeClass('disabled');
    $('#newTo').attr('disabled', false);
    $('#newTo').removeClass('disabled');
    $('#new-title').val('');
    $('#new-description').val('');
}

function openConnectionAdd(card){
    clearConnectionForm();
    $('#mode').val('Create');
    $('#newConnectionSubmit').text('Create');
    $('.connection-container').fadeIn();
    $('#card-name').text(card.data('label'));
    $('#newConnectionCard').val(card.data('card_id'));
    $('#newSelect option:disabled').attr('disabled', false);
    $('#newSelect option[value="' + card.data('card_id') + '"]').attr('disabled', true);
}

function closeConnection(){
    clearConnectionForm();
    $('.connection-container').fadeOut();
}

function deleteConnection(connection_id, cy, edge){
    $.ajax({
        method: "DELETE",
        url :'/my-sets/' + set_id + '/connection/' + connection_id
    }).done(function(data){
        if(data && data.deleted){
            cy.remove(edge);
        }
    }).fail(function(){
        alert('Something went wrong. Please refresh the page and try again.');
    });
}

function openConnectionEdit(connection){
    clearConnectionForm();
    $('#mode').val('Update');
    $('#editConnectionId').val(connection.data('connection_id'));
    var fromCard = connection.source();
    var toCard = connection.target();

    $('#card-name').text(fromCard.data('label'));

    $('#newSelect option:disabled').attr('disabled', false);

    $('#newSelect').attr('disabled', true);
    $('#newSelect').addClass('disabled');
    $('#newSelect').val(toCard.data('card_id')).change();

    $('#newFrom').attr('disabled', true);
    $('#newFrom').addClass('disabled');
    $('#newTo').attr('disabled', true);
    $('#newTo').addClass('disabled');
    $('input[name=newDirection]').val(['to']);

    $('#new-title').val(connection.data('label'));
    $('#new-description').val(connection.data('description'));

    $('#newConnectionSubmit').text('Update');

    $('#connection-box-title').text('Edit Connection');

    $('.connection-container').fadeIn();
}

function panForParameter(cy){
    if ('URLSearchParams' in window){
        var searchParams = new URLSearchParams(window.location.search);
        if(searchParams.has('card')){
            var nodeParam = searchParams.get('card');
            panToCardId(cy, nodeParam);
        }
    }
}

function panToCardId(cy, id){
    var nodes = cy.nodes('[' + "card_id = '" + id + "']");
    if(nodes.length == 1){
        cy.animate({zoom: 1.1, center: {eles: nodes[0]}});
    }
}


$(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if(network_elements.length != 0){
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
                            edgeElasticity: 0.5,
                            nestingFactor: 0.1,
                            numIter: 2500,
                            stop: function(){
                                $('#loader').fadeOut();
                                panForParameter(cy);
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
                        panForParameter(cy);
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
                        + '<div class="text-right"><div data-edge="'+ edge.data('id') + '" id="connection-delete" class="text-danger btn btn-text">Delete</div><div data-edge="'+ edge.data('id') + '" id="connection-edit" class="btn btn-text ml-2">Edit</div></div>'
                        );
                    document.body.appendChild(div);
                
                    $('.close').click(function(){
                        destroyPopper();
                    });

                    reallyDelete = false;
                    $('#connection-delete').click(function(){
                        if(!reallyDelete){
                            reallyDelete = true;
                            $(this).text('Really Delete?');
                            $(this).addClass('btn-danger');
                            $(this).removeClass('text-danger');
                        }else {
                            var edge_id = $(this).data()['edge'];
                            var connection = cy.getElementById(edge_id);
                            if(connection != null){
                                var connection_id = connection.data('connection_id');
                                deleteConnection(connection_id, cy, connection);
                                destroyPopper();
                            }
                        }
                    });

                    $('#connection-edit').click(function(){
                        var edge_id = $(this).data()['edge'];
                        var edge = cy.getElementById(edge_id);
                        if(edge != null){
                            destroyPopper();
                            openConnectionEdit(edge);
                        }
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
                        + '<div class="text-right mt-3"><div data-node="' + node.data('id') + '" class="add-connection btn btn-link text-decoration-none"><i class="fas fa-plus"></i><span class="pl-2">Add Connection</span></div><a class="btn btn-primary text-decoration-none" href="/my-sets/' + set_id + '/card/' + node.data('card_id') + '"><span class="pr-2">View Details</span><i class="fas fa-angle-double-right"></i></a></div>'
                    );
                    
                    document.body.appendChild(div);

                    $('.close').click(function(){
                        destroyPopper();
                    });

                    $('.add-connection').click(function(){
                        var card_id = $(this).data()['node'];
                        var card = cy.getElementById(card_id);
                        if(card != null){
                            destroyPopper();
                            openConnectionAdd(card);
                        }
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
            var element = event.target;
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



        
        $('.search').click(function(){
            closeMenu();
            openSearch();
        });


        $('.close-search').click(function(){
            closeSearch();
        });


        $(document).keydown(function(e) {
            if(e.ctrlKey && e.keyCode == 70){
                openSearch();
                e.preventDefault();
            }
        });

        $('#search-text').keyup(function(e){
            if(e.keyCode == 13){
                var card_id = $('.search-result div.visible').first().data()['card'];
                closeSearch();
                panToCardId(cy, card_id);
            } else {
                var filter = $(this).val().toUpperCase();
                if(filter != ''){
                    $('.search-result div').each(function(i,e){
                        e = $(e);
                        if(e.text().toUpperCase().indexOf(filter) > -1){
                            e.addClass('visible');
                        }else{
                            e.removeClass('visible');
                        }
                    });
                }else {
                    $('.search-result div').addClass('visible');
                }
            }
        });

        $('.search-result div').click(function(){
            var card_id = $(this).data()['card'];
            if(card_id){
                closeSearch();
                panToCardId(cy, card_id);
            }
        });

        $('.connection-cancel').click(function(){
            closeConnection();
        });

        $('#newSelect').select2();

        $('#newConnectionSubmit').click(function(){
            if($('#mode').val() == 'Create'){
                var currentCardId = $('#newConnectionCard').val();
                var newOtherCard = $('#newSelect').val();
                var newTitle = $('#new-title').val();
                var newDescription = $('#new-description').val();

                var fromCard = null;
                var toCard = null;

                var direction = $('input[name="newDirection"]:checked').val();
                if(direction === 'from'){
                    fromCard = newOtherCard;
                    toCard = currentCardId;
                } else if(direction === 'to'){
                    toCard = newOtherCard;
                    fromCard = currentCardId;
                }
                var valid = true;
                
                if(newTitle.length < 1){
                    valid = false;
                    $('#new-title').addClass('is-invalid');
                    $('#new-title').siblings('.invalid-tooltip').text('Please enter a longer title.');
                } else if (newTitle.length > 100){
                    valid = false;
                    $('#new-title').addClass('is-invalid');
                    $('#new-title').siblings('.invalid-tooltip').text('Please enter a shorter title.');
                }

                if(newDescription.length > 500){
                    valid = false;
                    $('#new-description').addClass('is-invalid');
                }

                //submit
                if(valid){
                    $.ajax({
                        method: "POST",
                        url :'/my-sets/' + set_id + '/connection/',
                        data: { 'title' : newTitle, 'description': newDescription, 'fromCardId' : fromCard, 'toCardId' : toCard},
                    }).done(function(data){
                        if(data && data.created){
                            //Success. Close window and create connection on the current graph.
                            closeConnection();
                            cy.add(
                                {
                                    group: 'edges',
                                    data:                    
                                    { 
                                        id: 'connection-' + data.id, 
                                        label: newTitle, 
                                        description: newDescription, 
                                        source: 'card-'+ fromCard, 
                                        target: 'card-' + toCard,
                                        connection_id: data.id.toString()
                                    }
                                }
                            );
                        } else {
                            alert('Something went wrong. Please refresh the page and try again.');
                        }
                    }).fail(function(){
                        alert('Something went wrong. Please refresh the page and try again.');
                    });
                }
            } else if($('#mode').val() == 'Update'){
                console.log('UPDATE');
                var newTitle = $('#new-title').val();
                var newDescription = $('#new-description').val();
                var editConnectionId = $('#editConnectionId').val();

                var valid = true;
                
                if(newTitle.length < 1){
                    valid = false;
                    $('#new-title').addClass('is-invalid');
                    $('#new-title').siblings('.invalid-tooltip').text('Please enter a longer title.');
                } else if (newTitle.length > 100){
                    valid = false;
                    $('#new-title').addClass('is-invalid');
                    $('#new-title').siblings('.invalid-tooltip').text('Please enter a shorter title.');
                }

                if(newDescription.length > 500){
                    valid = false;
                    $('#new-description').addClass('is-invalid');
                }

                if(valid){
                    $.ajax({
                        method: "PUT",
                        url :'/my-sets/' + set_id + '/connection/' + editConnectionId,
                        data: { 'title' : newTitle, 'description': newDescription},
                    }).done(function(data){
                        if(data && data.updated){
                            //Success. Close window and edit connection on the current graph.
                            closeConnection();
                            var edge = cy.$('#connection-' + editConnectionId);
                            if(edge){
                                edge.data('label', newTitle);
                                edge.data('description', newDescription);
                            }
                        } else {
                            alert('Something went wrong. Please refresh the page and try again.');
                        }
                    }).fail(function(){
                        alert('Something went wrong. Please refresh the page and try again.');
                    });
                }
            }
        });
    }

    $('.menu-btn').click(function(){
        openMenu();
    });
    $('.close-menu').click(function(){
        closeMenu();
    });
});