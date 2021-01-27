import smtplib, sys
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

gmail_user = 'swoopctms@gmail.com'
gmail_password = 'qlfwsrjhrzzbfknk'

receiver = sys.argv[1]
subject = sys.argv[2]
description = sys.argv[3]
deadline = sys.argv[4]
status = sys.argv[5]
task_id = sys.argv[6]
creator = sys.argv[7]

# Create message container - the correct MIME type is multipart/alternative.
msg = MIMEMultipart('alternative')
msg['Subject'] = subject
msg['From'] = gmail_user
msg['To'] = receiver

text = "TASK DUE: "+subject+"\n" 
text += "DEADLINE: "+deadline
text += "\n"+description+"\n"
text += status +"\n"


# subtasks section (only executes if arg 9 is set)
if len(sys.argv) == 9:
    subtask_list = sys.argv[8]
    subtask_list = subtask_list.split(",")

    subtasks = "<p><b>SUBTASKS</b></p><ul>{}</ul>"
        
    inner_ul = ""
    for item in subtask_list:
        inner_ul += "<li>"
        inner_ul += item
        inner_ul += "</li>"
        text += "*"+ item +"\n"
    
    subtasks = subtasks.format(inner_ul)



css = """\
<html>
    <head>
        <style>
            .btn-container {
                width: 100%;
            }
            .add-btn-2 {
                background-image: linear-gradient(315deg, #4c4177 0%, #2a5470 74%);
                color: white!important;
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
                <p><b>{}</b></p>
            </td>
        </tr>
    </table>
    <p><b>DESCRIPTION: </b>{}</p>
""" 

end_body = """\
    <p>Assigned by: <a href="mailto:{}">{}</a></p>
    <br>
    <div class="btn-container">
        <a href="https://swoop.team/views/task-details.php?task={}" class="add-btn-2">VIEW TASK</a>
    </div>
</body>
</html>
"""

text += "Assigned by: "+creator+"\n"
text = "[VIEW TASK][1]"
text += "[1]: https://swoop.team/views/task-details.php?task="+task_id

# append the HTML email together
body = body.format(subject, deadline, status, description)
end_body = end_body.format(creator, creator, task_id)

if len(sys.argv) == 9:
    html = css + body + subtasks + end_body
else:
    html = css + body + end_body


# attach message to MIME and send the email
if __name__ == "__main__":
    # Record the MIME types of both parts - text/plain and text/html.
    part1 = MIMEText(text, 'plain')
    part2 = MIMEText(html, 'html')

    # Attach parts into message container.
    # the HTML message, is best and preferred.
    msg.attach(part1)
    msg.attach(part2)

    try:
        server = smtplib.SMTP_SSL('smtp.gmail.com', 465)
        server.ehlo()
        server.login(gmail_user, gmail_password)
        server.sendmail(gmail_user, receiver, msg.as_string())
        print("Message sent!")
        server.close()
    except:
        print("message did not send...")