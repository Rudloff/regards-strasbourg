/*global Chart, $*/
/*jslint browser: true */
var init = function () {
    'use strict';
    var canvas = document.getElementsByClassName('graph'), i, graph, ctx;
    for (i = 0; i < canvas.length; i += 1) {
        graph = canvas.item(i);
        ctx = graph.getContext("2d");
        if (graph.dataset.type === 'Line2') {
            graph.dataset.type = 'Line';
        }
        new Chart(ctx)[graph.dataset.type](JSON.parse(decodeURIComponent(graph.dataset.data)), {animation: false});
    }
};
$(document).on("pageinit", init);
