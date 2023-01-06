@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
<script src="/extra/jstree/dist/jstree.min.js"></script>
<link rel="stylesheet" href="/extra/jstree/dist/themes/default/style.min.css" />
@endpush

<x-filament::page>
  <div id="jstree-div" wire:ignore></div>
</x-filament::page>

<script>

  window.addEventListener( 'DOMContentLoaded', function ()
  {
    jstreeInit();
  } );

  function jstreeInit()
  {
    jsTreePerm = $( '#jstree-div' );
    jsTreePerm.jstree({
      "core": {
        "data" : {{ Js::from($perms) }},
        "check_callback": true,
      },
      "plugins": [ "checkbox", "types" ],
      "checkbox": {
        "keep_selected_style": false
      },
      "types": {
        "root": {
          "icon": "fa fa-desktop text-primary"
        },
        "default": {
          "icon": "fa fa-folder"
        },
        "key": {
          "icon": "fa fa-key"
        }
      }
    }).on( 'loaded.jstree', function (e, data)
    {
      let selected = @this.selected;
      let tree = data.instance;
      let nodes = tree.get_json('#', {flat: true});
      tree.open_all();
      for(let node of nodes) {
        if (selected.includes(node.id)) {
          console.log(node.id);
          tree.select_node(node.id);
        }
      }
    })
    .on('changed.jstree', function(e, data) {
      var i, j, r = [];
      for(i = 0, j = data.selected.length; i < j; i++) {
        r.push(data.instance.get_node(data.selected[i]).id);
      }
      @this.selected = r;
    });
  }
</script>