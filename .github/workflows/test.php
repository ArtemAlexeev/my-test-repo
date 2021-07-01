name: Test status
on:
  push:
jobs:
  test-status-job:
    runs-on: ubuntu-latest
    steps:
      - name: Parse Jira ticket id
        shell: bash
        id: ticket-id
        run: echo "##[set-output name=issue;]$(echo ${GITHUB_REF#refs/heads/} | grep -oP '^ALDEV-\d+')"

      - name: Echo Jira ticket id
        run: echo "${{ steps.ticket-id.outputs.issue }}"

      - name: login
        uses: atlassian/gajira-login@master
        env:
          JIRA_BASE_URL: ${{ secrets.JIRA_BASE_URL }}
          JIRA_USER_EMAIL: ${{ secrets.JIRA_USER_EMAIL }}
          JIRA_API_TOKEN: ${{ secrets.JIRA_API_TOKEN }}

      - name: Move to Done status
        uses: atlassian/gajira-transition@master
        with:
          issue: ${{ steps.ticket-id.outputs.issue }}
          transition: "Done" # Code review