name: Jira ticket to Merged status
on:
  pull_request:
    types: [closed]
jobs:
  merged-status-job:
    runs-on: ubuntu-latest
    if: github.event.pull_request.merged == true
    steps:
      - name: Parse Jira ticket id
        shell: bash
        id: ticket-id
        run: echo "##[set-output name=issue;]$(echo ${{ github.head_ref }} | grep -oP '^ALDEV-\d+')"

      - name: Login to Jira
        uses: atlassian/gajira-login@master
        env:
          JIRA_BASE_URL: ${{ secrets.JIRA_BASE_URL }}
          JIRA_USER_EMAIL: ${{ secrets.JIRA_USER_EMAIL }}
          JIRA_API_TOKEN: ${{ secrets.JIRA_API_TOKEN }}

      - name: Move to Merged status
        uses: atlassian/gajira-transition@master
        with:
          issue: ${{ steps.ticket-id.outputs.issue }}
          transition: "Done" # here will be Merged