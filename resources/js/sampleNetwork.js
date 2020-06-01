
let cytoscape = require('cytoscape');
let popper = require('cytoscape-popper');
let tippy = require('tippy.js/dist/tippy-bundle.cjs').default;

cytoscape.use( popper ); // register extension

$(function(){

    var cy = cytoscape({
        
        container: $('#cy'), // container to render in
        
        elements: [ // list of graph elements to start with
            { // node a
                data: { id: 'a', label: 'Cassidy Murphy' }
            },
            { // node b
                data: { id: 'b', label: 'Jacob Murphy' }
            },
            { // edge ab
                data: { id: 'ab', label: "Married", source: 'b', target: 'a' }
            },
            { // another edge
                data: { id: 'ab2', label: "Makes good food for", source: 'a', target: 'b' }
            },
            { // node c
                data: { id: 'c', label: 'Drums' }
            },
            { // node d
                data: { id: 'd', label: 'Piano' }
            },
            { 
                data: { id: 'bc', label: "Plays", source: 'b', target: 'c' }
            },
            { 
                data: { id: 'ad', label: "Plays", source: 'a', target: 'd' }
            },
            { // node d
                data: { id: 'e', label: 'Philosophical Foundations for a Christian Worldview by William Lane Craig and JP Moreland' }
            },
            { 
                data: { id: 'be', label: "Reads", source: 'b', target: 'e' }
            },
        ],
        
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
            name: 'grid',
            rows: 2
        }
        
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


    cy.on('mouseover', 'node,edge', function(e){
        $('#cy').addClass('mouse-over');
    });
    cy.on('mouseout', 'node,edge', function(e){
        $('#cy').removeClass('mouse-over');
    });



    /********EXPORT*******/
    $('.export').click(function(){
        $('.modal-json').text(JSON.stringify(cy.json(), null, "\t"));
        $('.modal').modal('show');
    });

});