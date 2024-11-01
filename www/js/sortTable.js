// use strict mode, prevents to use undeclared variables 
"use strict";

// http://jsfiddle.net/zscQy/ 

function sortTable(table, col, reverse) {
    let tb = table.tBodies[0] 
    // use `<tbody>` to ignore `<thead>` and `<tfoot>` rows
    let tr = Array.prototype.slice.call(tb.rows, 0) 
        // put rows into array
    let i
    reverse = -((+reverse) || -1);
    
    tr = tr.sort(function (a, b) { 
        // sort rows
        return reverse // `-1 *` if want opposite order
            * (a.cells[col].textContent.trim() 
            // using `.textContent.trim()` for test
                .localeCompare(b.cells[col].textContent.trim())
              );
    });
    
    for(i = 0; i < tr.length; ++i) {
        tb.appendChild(tr[i]); 
    }
    // append each row in order
}

function makeSortable(table) {
    var th = table.tHead, i;
    th && (th = th.rows[0]) && (th = th.cells);
    if (th) {
        i = th.length;
    }   
    else return // if no `<thead>` then do nothing
    while (--i >= 0) // it should be read value of i will be checked if it greater than 0, if it is true then control will enter the while block, if it is false while block will be skipped //
        (function (i) {
        var dir = 1;
        
        th[i].addEventListener('click', function () {
            sortTable(table, i, (dir = 1 - dir))
        });
    }(i));
}

function makeAllSortable(parent) {
    parent = parent || document.body;
    var t = parent.getElementsByTagName('table'), i = t.length;
    while (--i >= 0) makeSortable(t[i]);
}

window.onload = function () {
    makeAllSortable();
};
