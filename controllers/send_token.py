import smtplib, sys
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

gmail_user = 'swoopctms@gmail.com'
gmail_password = 'qlfwsrjhrzzbfknk'
receiver = sys.argv[1]
token = sys.argv[2]

html, text = "", ""

html += "<html><head><style>"
html += ".uline {border-bottom: solid #ddd;}</style></head>"
html += "<body><h3>A password reset has been requested</h3>"
html += "<div class='uline'></div>"
html += "<h3><a href='http://10.0.0.52/authentication/change_pswd.php?token="+token
html += "'>Click here to reset your password</a></h3>" 

text += "Click here to reset your password "+token
text += "[1]: https://swoop.team/authentication/change_pswd.php?token="+token
text += "A password reset has been requested \n"
text += "[Click this link to reset your password][1]"
html += "</body></html>"


# attach message to MIME and send the email
if __name__ == "__main__":
    msg = MIMEMultipart('alternative')
    msg['Subject'] = "Password reset request"
    msg['From'] = gmail_user
    msg['To'] = receiver

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
