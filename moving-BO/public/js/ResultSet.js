/* Default class modification */
$.extend($.fn.dataTableExt.oStdClasses, {
	"sWrapper": "dataTables_wrapper form-inline"
});

/* API method to get paging information */
$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
	return {
		"iStart":         oSettings._iDisplayStart,
		"iEnd":           oSettings.fnDisplayEnd(),
		"iLength":        oSettings._iDisplayLength,
		"iTotal":         oSettings.fnRecordsTotal(),
		"iFilteredTotal": oSettings.fnRecordsDisplay(),
		"iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
		"iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
	};
};

/* Bootstrap style pagination control */
$.extend( $.fn.dataTableExt.oPagination, {
	"bootstrap": {
		"fnInit": function(oSettings, nPaging, fnDraw) {
			var oLang = oSettings.oLanguage.oPaginate;
			var fnClickHandler = function (e) {
				e.preventDefault();
				if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
					fnDraw( oSettings );
				}
			};

			$(nPaging).addClass('pagination').append(
				'<ul>'+
					'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
					'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
				'</ul>'
			);
			var els = $('a', nPaging);
			$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
			$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
		},

		"fnUpdate": function ( oSettings, fnDraw ) {
			var iListLength = 5;
			var oPaging = oSettings.oInstance.fnPagingInfo();
			var an = oSettings.aanFeatures.p;
			var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

			if (oPaging.iTotalPages < iListLength) {
				iStart = 1;
				iEnd = oPaging.iTotalPages;
			} else if ( oPaging.iPage <= iHalf ) {
				iStart = 1;
				iEnd = iListLength;
			} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
				iStart = oPaging.iTotalPages - iListLength + 1;
				iEnd = oPaging.iTotalPages;
			} else {
				iStart = oPaging.iPage - iHalf + 1;
				iEnd = iStart + iListLength - 1;
			}

			for (i=0, iLen=an.length; i<iLen; i++) {
				// Remove the middle elements
				$('li:gt(0)', an[i]).filter(':not(:last)').remove();

				// Add the new list items and their event handlers
				for ( j=iStart ; j<=iEnd ; j++ ) {
					sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
					$('<li '+sClass+'><a href="#">'+j+'</a></li>')
						.insertBefore( $('li:last', an[i])[0] )
						.bind('click', function (e) {
							e.preventDefault();
							oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
							fnDraw( oSettings );
						} );
				}

				// Add / remove disabled classes from the static elements
				if ( oPaging.iPage === 0 ) {
					$('li:first', an[i]).addClass('disabled');
				} else {
					$('li:first', an[i]).removeClass('disabled');
				}

				if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
					$('li:last', an[i]).addClass('disabled');
				} else {
					$('li:last', an[i]).removeClass('disabled');
				}
			}
		}
	}


} );

/**
 * Método utilizado para fazer com que a busca no plugin seja feito apÃ³s a tecla
 * "enter" ser precionada, e nÃ£o através do evento keyup. 
 */ 
jQuery.fn.dataTableExt.oApi.fnFilterOnReturn = function(oSettings) {
	var _that = this;

	this.each(function(i) {
		$.fn.dataTableExt.iApiIndex = i;
		
		var anControl = $('input', _that.fnSettings().aanFeatures.f);
		
		anControl.unbind('keyup').bind('keypress', function(e) {
			if (e.which == 13) {
				$.fn.dataTableExt.iApiIndex = i;
				_that.fnFilter(anControl.val());
			}
		});
		
		return this;
	});
	
	return this;
};

var ResultSet = new function() {


	return {

		paginate : function(element, values, callback) {
			
			if( !(element instanceof jQuery) ){
				alert("L'argument passé à dataTable n'est pas un élément du DOM")
				return false;
			}
			
			if( !(element.is('table')) ){
				alert("L'argument passé à dataTable n'est pas un élément table")
				return false;
			}

			var params = {
				"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"oPaginate": {
						"sFirst": "Premier",
						"sNext": "Prochain",
						"sPrevious": "Précédent",
						"sLast": "Dernier"
					},
					"sLengthMenu": "Afficher _MENU_ éléments par page",
					"sZeroRecords": "Aucun résultat trouvé",
					"sInfo": "Affiche de _START_ à _END_ sur _TOTAL_ éléments",
					"sInfoEmpty": "Aucun enregistrement à afficher",
					"sInfoFiltered": "(filtrés à partir de _MAX_ entrées)",
					"sSearch": "Recherche ",
					"sEmptyTable": "La table est vide",
					"sLoadingRecords": "Chargement...",
					"sProcessing": "En cours de traitement..."
				}
				/*"bProcessing": false,
				"bServerSide": false,
				"sAjaxSource": "",
				"fnDrawCallback": function () {
				},
				"aoColumnDefs": [ {"bSortable": false, "aTargets": [4]} ] */
			};
			
			if(typeof values != 'undefined'){
				for (var i in values) {
					if (values.hasOwnProperty(i)) {
						//console.log(i + " = " + values[i]);
						params[i] = values[i];
					}
				}
			}

			var data = element.dataTable(params).fnFilterOnReturn();

			if(typeof callback == "function"){
				callback();
			}

			return data;
		}
		
		
	};
	
};
