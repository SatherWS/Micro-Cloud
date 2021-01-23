import smtplib, sys
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

gmail_user = 'swoopctms@gmail.com'
gmail_password = 'qlfwsrjhrzzbfknk'

receiver = sys.argv[1]
subject = "TASK DUE: "+sys.argv[2]
description = sys.argv[3]
deadline = sys.argv[4]

# Create message container - the correct MIME type is multipart/alternative.
msg = MIMEMultipart('alternative')
msg['Subject'] = subject
msg['From'] = gmail_user
msg['To'] = receiver

text = sys.argv[3] + " is due on " + deadline
css = """\
<html>
    <head>
        <style>
            .btn-container {
                width: 100%;
            }
            .add-btn-2 {
                background-image: linear-gradient(315deg, #4c4177 0%, #2a5470 74%);
                color: white;
                padding: .75rem;
                border-radius: 8px;
            }
            .uline {
               border-bottom: solid #ddd;
            }
        </style>
    </head>
"""

body = """\
<body>
    <h2>TASK DUE: {}</h2>
    <div class="uline"></div>
    <table style='100%'>
        <tr>
            <td>
                <p><b>DEADLINE:</b> {}</p>
            </td>
            <td align="right">
                <p><b>TEMP</b></p>
            </td>
        </tr>
    </table>
    <p><b>DESCRIPTION: </b>{}</p>
    <p><b>SUBTASKS</b></p>
    <ul>
        <li>TEMP</li>
    </ul>
    <p>Assigned by: <a href="mailto:TEMP">TEMP</a></p>
    <br>
    
    <div class="btn-container">
        <a href="https://swoop.team/views/task-details.php?task=420" class="add-btn-2">VIEW TASK</a>
    </div>
</body>
</html>
"""
body = body.format(subject, deadline, description)
html = css + body

print(html)
