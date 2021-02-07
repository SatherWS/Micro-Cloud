import smtplib, sys
import pymysql
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText

db = pymysql.connect(host='localhost', user='root', passwd='1m0r3_projde@th', db='swoop')
db.autocommit(True)

gmail_user = 'swoopctms@gmail.com'
gmail_password = 'qlfwsrjhrzzbfknk'
receiver = sys.argv[1]

curs = db.cursor()
sql = "select token from tokens where email = %s order by date_requested"
curs.execute(sql, [receiver])
data = curs.fetchone()
html, text = "", ""

html += "<html><head><style>"
html += ".uline {border-bottom: solid #ddd;}</style></head>"
html += "<body><h2>A password reset has been requested</h2>"
html += "<div class='uline'></div>"
html += "<a href='https://swoop.team/authentication/change_pswd.php?token="+data[0][0]
html += "'>Click this link to reset your password</a>" 

text += "Click this link to reset your password "+data[0][0]
text += "[1]: https://swoop.team/authentication/change_pswd.php?token="+data[0][0]
text += "A password reset has been requested \n"
text += "[Click this link to reset your password][1]"

html += "</body></html>"
print(html, text)
curs.close()
db.close()

# attach message to MIME and send the email
if __name__ == "__main__":
    msg = MIMEMultipart('alternative')
    msg['Subject'] = "Password reset has been requested"
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