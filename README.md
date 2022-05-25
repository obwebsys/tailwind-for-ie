# tailwind-for-ie

## [Wordpress Plugin] Tailwind.css v3 CDN enabler for IE11

- Tags: tailwind.css, css, custom, ie11
- Requires at least: 5.0
- Tested up to: 5.9.3
- Stable tag: 1.0.0
- License: GPLv2 or later
- License URI: http://www.gnu.org/licenses/gpl-2.0.html
- Requires PHP: 7.0

- You must be using the Tailwind.css v3 CDN. After activating the plugin, it is necessary to display the target page on the modern browser. (Because it is necessary to capture the inline style output by tailwind.css and prepare it as css for IE11)

## == Description ==

- Tailwind.css v3 CDNを利用している場合、IE11用に静的CSSファイルを作成して配置して読み込ませるプラグインです。
- Tailwind.css v3 CDNが吐き出すインラインスタイルをキャプチャして、モダンブラウザかつログイン中ユーザーによる表示中にバックグラウンドでcssファイルを組み立てておきます。
- なのでIE11表示は最後の最後にテストする、という方向けです。ワンボタンでプリフェッチして作っておく機能は検討中です。
- Tailwind.css v3 CDNが将来的になくなった場合に備えて、css内容をバックアップしておく用途にも使えます。
- 基本的にcss内容は追記のみなので、肥大化するかもしれませんのでクリーンする機能も必要かもしれません。開発中は止めておくなど、プラグイン有効化タイミングで調整してね。もしくは手動で適宜cssファイル消してね。


### こんな感じでtailwind.cssをCDNで読み込んでいる方向けのプラグインです。

```
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
   theme: {
      screens: {
         'sp':  {'max': '767px'},
      }
   }
}
</script>
```


* You must be using the Tailwind.css v3 CDN.
* it is necessary to display the target page on the modern browser for Cache creation.
* (Because it is necessary to capture the inline style output by tailwind.css and prepare it as css for IE11)
* Important: To create the cache, you need to be logged in to WP & browsing with a modern browser such as Chrome.

* structure
   * capture Tailwind.css's inline style output in modern browser.
   * if captured, auto generate style_tw_ie.css in plugin's folder.
   * Duplicate css is removed. maybe.
   * Since it is the final phase of the test to check in IE11 anyway, it will not be a problem if css is completed after displaying a series of pages in a modern browser.
   * I'm thinking about the function to load all pages in advance.


## == Installation ==

1. From the WP admin panel, click "Plugins" -> "Add new".
2. In the browser input box, type "Tailwind.css v3 CDN enabler for IE11".
3. Select the "Tailwind.css v3 CDN enabler for IE11" plugin and click "Install".
4. Activate the plugin.

OR…

1. Download the plugin from this page.
2. Save the .zip file to a location on your computer.
3. Open the WP admin panel, and click "Plugins" -> "Add new".
4. Click "upload".. then browse to the .zip file downloaded from this page.
5. Click "Install".. and then "Activate plugin".


## == Frequently asked questions ==



## == Screenshots ==



## == Changelog ==

### = 1.0.0 =
First Commit.


## == Upgrade notice ==

