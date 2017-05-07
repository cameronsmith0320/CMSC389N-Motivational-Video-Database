'use strict';

main();

function main(){
    if(document.getElementById("playlistSelect"))
        document.getElementById("playlistSelect").onchange = playlistSelectChange;
}

function playlistSelectChange(){
    let select = document.getElementById("playlistSelect");
    if(select.options[select.selectedIndex].value == "new"){
        document.getElementById("newPlaylist").innerHTML = '\
                <div class="form-group">\
                    <label for="playlist"> Add to playlist </label>\
                    <input class="form-control" type="text" value="New Playlist" name="playlistCreate"/>\
                    <small class="form-text text-muted"> This will create a new playlist to hold your video </small>\
                </div>\
        ';
    }else{
        document.getElementById("newPlaylist").innerHTML = null;
    }

}
