using UnityEngine;
using System.Collections;
using System.Net;
using UnityEngine.EventSystems;

public class DataPinger : MonoBehaviour {

    public string m_GetRequestURL = "https://ec2-54-206-12-233.ap-southeast-2.compute.amazonaws.com/MobileSubmit.php";
    public EventSystem m_EventSystem;
    public GameObject m_XYPad;

    public void Update()
    {
        if (Input.GetMouseButtonDown(0))
        {
            if (m_EventSystem.currentSelectedGameObject == m_XYPad)
            {
                float xNormal = (Input.mousePosition.x - m_XYPad.GetComponent<RectTransform>().rect.xMin) / (m_XYPad.GetComponent<RectTransform>().rect.xMax - m_XYPad.GetComponent<RectTransform>().rect.xMin);
                float yNormal = (Input.mousePosition.y - m_XYPad.GetComponent<RectTransform>().rect.yMin) / (m_XYPad.GetComponent<RectTransform>().rect.yMax - m_XYPad.GetComponent<RectTransform>().rect.yMin);
                SendMessage("XYCoord", xNormal.ToString("0.0000") + "," + yNormal.ToString("0.0000"));
            }
        }
    }

    public void SetState(int stateIndex)
    {
        StateChange newState = (StateChange)stateIndex;
        SendMessage("StateChange", newState.ToString());
    }


    public void SendMessage(string RequestType, string Value)
    {
        try
        {
            System.Guid guid = new System.Guid();

            WebClient webClient = new WebClient();
            webClient.QueryString.Add("GUID", guid.ToString());
            webClient.QueryString.Add("RequestType", RequestType);
            webClient.QueryString.Add("Value", Value);
            string result = webClient.DownloadString(m_GetRequestURL);
            print(result);
        }
        catch (System.Exception e)
        {
            print("Problem sending request. " + e.ToString());
        }
    }
}

enum StateChange
{
    State1,
    State2,
    State3,
    State4
}
