<!DOCTYPE html>
<html>
<head>
    <title>MathJax TeX Test Page</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js">
    </script>
</head>
<body>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <p>Nội dung câu hỏi:</p> 
            @foreach($content->content AS $row)
            <p>{!!$row->content!!}</p>
            @endforeach
        <p>Các lựa chọn:</p> 
            @foreach($content->answers AS $row)
            <p>{!!$row->text[0]->content!!}</p>
            @endforeach
        <p>Gợi ý:</p> 
            @foreach($solution_suggesstion AS $row)
            <p>{!!$row->content!!}</p>
            @endforeach
        <p>Đáp án:</p> 
            @foreach($answer->solution_content AS $row)
            <p>{!!$row->content!!}</p>
            @endforeach
        <p>Giải thích</p>
            @foreach($answer->solution_detail AS $row)
            <p>{!!$row->content!!}</p>
            @endforeach
    </div>
</body>

</html>