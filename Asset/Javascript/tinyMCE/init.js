var SITE = location.origin + '/Iron/';
var STYLE = SITE + 'Asset/Style/';
var RFM = SITE + 'Asset/Filemanager/';

tinymce.init({
    selector: ".tinymce",
	language : "fr_FR",
	
	inline: false,
	content_css : STYLE + "base.css",
		
	image_caption: true,
	image_advtab: true,
	media_live_embeds: true,
	end_container_on_empty_block: true,
    relative_urls: false,
    
    templates: [
		{ title: 'Lorem Ipsum (5 paragraphes)', content: '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean sodales hendrerit massa quis mattis. Fusce ullamcorper purus massa, eu sollicitudin elit ullamcorper id. Duis quis odio sem. Curabitur hendrerit dictum sem et malesuada. Suspendisse nec nulla eu ipsum pretium pharetra consectetur vel massa. Vestibulum sagittis gravida interdum. Vivamus et est quis nisi consectetur iaculis. Fusce vestibulum velit mauris. Pellentesque rhoncus scelerisque lorem, vel ultricies est scelerisque nec. Cras auctor odio tortor, a molestie leo accumsan in. Sed turpis odio, condimentum vitae libero eget, maximus feugiat sem. Curabitur fermentum lorem eu erat ultricies bibendum sed et elit.</p><p>Proin et lobortis purus. Vestibulum vel ex a dolor pellentesque viverra eu iaculis dui. Fusce ut malesuada dolor, sit amet dignissim metus. Aliquam imperdiet arcu in magna lobortis porta. Quisque ac elementum tortor. In lorem magna, sodales at blandit sit amet, laoreet ut enim. Pellentesque laoreet risus venenatis turpis feugiat vestibulum. Donec a ligula molestie mi aliquam porta non ac metus. Cras in ex euismod, hendrerit orci at, auctor nunc. Etiam nec erat ex. Morbi vitae augue quis turpis ullamcorper placerat ac tempor magna.</p><p>Suspendisse vulputate dapibus erat, at porttitor est rutrum eu. Donec sit amet eros libero. Nam sed eleifend lacus. In maximus diam ac lobortis fermentum. Etiam nec volutpat risus. Sed vel facilisis orci. Donec pulvinar eget sapien eget sodales. Quisque varius quis enim non pharetra. Donec suscipit condimentum dui, quis aliquet tellus dapibus at.</p><p>Maecenas sollicitudin ornare odio sit amet fringilla. Nam fringilla nibh risus, non varius lacus viverra id. Pellentesque non dolor libero. Duis gravida et nibh vel ultrices. Nam faucibus finibus risus in efficitur. Vestibulum erat dui, fermentum sed fringilla vitae, consequat pretium nulla. Fusce libero quam, convallis ac massa non, pellentesque maximus nisi. Sed mattis sem in eros dignissim, ut commodo nisi finibus. Aliquam egestas metus dolor, nec dapibus mi maximus vel. Vestibulum sagittis libero augue, ac maximus eros tempus eu. Aenean mi velit, dignissim id eros id, commodo venenatis velit.</p><p>Donec pretium odio ante, ut tempus sem sollicitudin ac. Sed laoreet ut erat eget finibus. Curabitur viverra ligula vel sapien ullamcorper, eget pulvinar nisi pellentesque. Cras eget viverra massa. Phasellus eget libero fermentum, scelerisque ligula eu, scelerisque est. Vestibulum commodo massa quam, et tempor magna lacinia at. Pellentesque non est nunc.</p>' }
	],
       
    plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
	    'searchreplace wordcount visualblocks visualchars code fullscreen',
	    'insertdatetime media nonbreaking save table contextmenu directionality',
	    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc',
	    'responsivefilemanager'
    ],

    toolbar: "undo redo | insert | styleselect bold italic underline  | alignleft aligncenter alignright alignjustify | outdent indent table bullist numlist | link image media codesample",
    
	external_filemanager_path: RFM,
	filemanager_title: "Gestionnaire de fichiers",
	external_plugins: { "filemanager" : RFM + "plugin.min.js"}

});