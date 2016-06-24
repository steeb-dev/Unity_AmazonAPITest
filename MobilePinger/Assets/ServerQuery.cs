using UnityEngine;
using System.Collections;
using System.Net;

public class ServerQuery : MonoBehaviour {
    public string m_GetRequestURL = "https://ec2-54-206-73-97.ap-southeast-2.compute.amazonaws.com/ServerRequest.php";
    public UnityEngine.UI.Text m_LatestResults;
    public UnityEngine.UI.InputField m_RequestType;
    public UnityEngine.UI.InputField m_MaxResults;
    public UnityEngine.UI.InputField m_NoOlderThan;
    public UnityEngine.UI.Toggle m_UnreadOnly;

    public void RunQuery()
    {
        try
        {
            System.Guid guid = new System.Guid();

            WebClient webClient = new WebClient();
            webClient.QueryString.Add("QueryType", "List");
            string paramsString = "";
            paramsString += "RequestType=" + m_RequestType.text + "|";
            paramsString += "MaxResults=" + m_MaxResults.text + "|";
            paramsString += "NoOlderThan=" + m_NoOlderThan.text + "|";
            paramsString += "UnreadOnly=" + m_UnreadOnly.isOn.ToString().ToUpper();

            webClient.QueryString.Add("Parameters", paramsString);
            string result = webClient.DownloadString(m_GetRequestURL);
            m_LatestResults.text = result;
        }
        catch (System.Exception e)
        {
            print("Problem sending request. " + e.ToString());
        }
    }

    public void MarkAllAsRead()
    {
        try
        {
            System.Guid guid = new System.Guid();

            WebClient webClient = new WebClient();
            webClient.QueryString.Add("QueryType", "MarkAsRead");
            webClient.QueryString.Add("Parameters", "");
            string result = webClient.DownloadString(m_GetRequestURL);
            m_LatestResults.text = result;
        }
        catch (System.Exception e)
        {
            print("Problem sending request. " + e.ToString());
        }
    }
}
