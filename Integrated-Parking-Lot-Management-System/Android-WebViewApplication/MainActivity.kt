package com.example.capstoneproject

import android.os.Bundle
import android.webkit.WebChromeClient
import android.webkit.WebView
import android.webkit.WebViewClient
import android.widget.Toast
import androidx.appcompat.app.AppCompatActivity

class MainActivity : AppCompatActivity() {
    private var backKeyPressedTime = 0.1

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        val myWebView: WebView = findViewById(R.id.webView)

        myWebView.settings.javaScriptEnabled = true //자바스크립트 허용
        myWebView.webViewClient = WebViewClient() //웹뷰에서 새 창 띄우지 않도록 방지
        myWebView.webChromeClient = WebChromeClient() //크롬창에 띄우는게 아닌 웹뷰에 띄우기

        myWebView.loadUrl("http://웹 호스팅된 아이피/") //AWS EC2 서버
    }
    override fun onBackPressed() {
        val myWebView: WebView = findViewById(R.id.webView)

        if(myWebView.canGoBack()) //웹사이트에서 뒤로 갈 페이지 존재 한다면,
        {
            myWebView.goBack() //웹사이트 뒤로가기
        }
        else //뒤로갈 페이지 없음. 앱 종료
        {
            if (System.currentTimeMillis() > backKeyPressedTime + 2000){
                backKeyPressedTime = System.currentTimeMillis().toDouble()
                Toast.makeText(applicationContext,"Press one more time to exit.\n 한번 더 누르면 종료됩니다.",Toast.LENGTH_SHORT).show()
                return
            }
            if(System.currentTimeMillis() <= backKeyPressedTime + 2000) {
                super.onBackPressed() //본래 Back 버튼 수행 (앱 종료)
            }
        }
    }
}