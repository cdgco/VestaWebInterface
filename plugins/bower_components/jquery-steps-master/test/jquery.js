(function ()
{
    var versionPattern = /^[\?|\&]{1***REMOVED***version=(\d\.\d\.\d|latest)&?$/,
        version = versionPattern.exec(location.search),
        defaultVersion = "1.11.1",
        file = "http://code.jquery.com/jquery-git.js";

    if (version != null && version.length > 0)
    {
        version = version[1];
    ***REMOVED***
    else
    {
        version = defaultVersion;
    ***REMOVED***

    if (version !== "latest")
    {
        file = "../lib/jquery-" + version + ".min.js";
    ***REMOVED***

    document.write("<script src='" + file + "'></script>");
***REMOVED***)();