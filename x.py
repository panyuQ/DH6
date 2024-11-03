data = """
{
    "style": {
        "margin": {
            "top": "100px"
        },
        "padding": {
            "left": "100px",
            "right": "100px"
        }
    },
    "label": {
        "position": "top"
    },
    "api": {
        "/find/other/base": {
            "ip": "ip",
            "time": "time"
        }
    },
    "content": [
        {
            "gutter": 20,
            "COLS": [
                {
                    "span": 5,
                    "element": "ElText",
                    "style": {
                        "color": "#fff",
                        "fontSize": "1.25rem"
                    },
                    "label": {
                        "content": "当前登录IP",
                        "styel": {
                            "textAlign": "center"
                        }
                    },
                    "text": {
                        "field": "ip"
                    }
                },
                {
                    "span": 5,
                    "element": "ElText",
                    "style": {
                        "color": "#fff",
                        "fontSize": "1.25rem"
                    },
                    "label": {
                        "content": "截至时间",
                        "style": {
                            "textAlign": "center"
                        }
                    },
                    "text": {
                        "field": "time"
                    }
                }
            ]
        }
    ]
}
"""

print(data.replace("\n", "").replace(" ", ""))