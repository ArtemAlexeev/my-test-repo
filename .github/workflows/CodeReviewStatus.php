name: Move to Code Review status
on:
  pull_request:
    types: [opened]
jobs:
  code-review-status-job:
    runs-on: ubuntu-latest
    steps:
      - name: Parse Jira ticket id
        shell: bash
        id: ticket-id
        run: echo "##[set-output name=issue;]$(echo ${{ github.head_ref }} | grep -oP '^ALDEV-\d+')"

      - name: Echo Jira ticket id
        run: echo "${{ steps.ticket-id.outputs.issue }}"

      - name: Login to Jira
        uses: atlassian/gajira-login@master
        env:
          JIRA_BASE_URL: ${{ secrets.JIRA_BASE_URL }}
          JIRA_USER_EMAIL: ${{ secrets.JIRA_USER_EMAIL }}
          JIRA_API_TOKEN: ${{ secrets.JIRA_API_TOKEN }}

      - name: Move to In Progress status
        uses: atlassian/gajira-transition@master
        with:
          issue: ${{ steps.ticket-id.outputs.issue }}
          transition: "In Progress" # here will be Code Review status
